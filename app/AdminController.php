<?php

use PHPMailer\PHPMailer\Exception;

class AdminController {
    private $user;
    private $card;
    private $transaction;
    private $admin;
    private $emailService;

    public function __construct() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?page=admin-login');
            exit;
        }
        
        $this->user = new User();
        $this->card = new Card();
        $this->transaction = new Transaction();
        $this->admin = new Admin();
        $this->emailService = new EmailService();
    }

    public function index($extra = []) {
        $stats = $this->getStats();
        $recentUsers = $this->user->getRecentUsers(10);
        $recentTransactions = $this->transaction->getRecentTransactions(10);
        $recentCards = $this->card->getRecentCards(10);
        include 'views/admin/dashboard.php';
    }

    public function users() {
        $users = $this->user->getAllUsers();
        include 'views/admin/users.php';
    }

    public function createUser() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $initialBalance = floatval($_POST['initial_balance'] ?? 0);

            // Validation
            if (empty($name) || empty($username) || empty($email) || empty($password)) {
                $error = 'Name, username, email, and password are required.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
                $error = 'Username must be 3-20 characters and contain only letters, numbers, and underscores.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif ($this->user->findByEmail($email)) {
                $error = 'Email address already exists.';
            } elseif ($this->user->findByUsername($username)) {
                $error = 'Username already exists.';
            } else {
                // Create user
                $userId = $this->user->create([
                    'name' => $name,
                    'username' => $username,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password,
                    'balance' => $initialBalance
                ]);

                if ($userId) {
                    // Send welcome email
                    try {
                        $emailService = new EmailService();
                        $emailService->sendWelcomeEmail($email, $name, $username);
                    } catch (Exception $e) {
                        // Log error but don't prevent user creation
                        error_log("Welcome email failed for $email: " . $e->getMessage());
                    }
                    
                    // If initial balance is provided, record it as a transaction
                    if ($initialBalance > 0) {
                        $this->transaction->create([
                            'user_id' => $userId,
                            'card_id' => null,
                            'type' => 'account_topup',
                            'amount' => $initialBalance,
                            'description' => 'Initial balance (Admin)'
                        ]);
                    }

                    $success = 'User created successfully!';
                    
                    // Redirect to manage the new user
                    header('Location: ?page=admin&action=manage_user&id=' . $userId);
                    exit;
                } else {
                    $error = 'Failed to create user. Please try again.';
                }
            }
        }

        include 'views/admin/create_user.php';
    }

    public function cards() {
        $cards = $this->card->getAllCards();
        include 'views/admin/cards.php';
    }

    public function deleteCardGlobal() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin&action=cards');
            exit;
        }

        $cardId = intval($_POST['card_id']);
        $userId = intval($_POST['user_id']);
        
        try {
            $this->deleteCard(['card_id' => $cardId, 'user_id' => $userId]);
            header('Location: ?page=admin&action=cards&success=card_deleted');
        } catch (Exception $e) {
            header('Location: ?page=admin&action=cards&error=delete_failed');
        }
        exit;
    }

    public function transactions() {
        $transactions = $this->transaction->getAllTransactions();
        include 'views/admin/transactions.php';
    }

    public function manageUser() {
        $userId = $_GET['id'] ?? 0;
        $user = $this->user->findById($userId);
        $userCards = $this->card->findByUser($userId);
        $userTransactions = $this->transaction->findByUser($userId, 20);
        
        $success = '';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'update_balance':
                    $this->updateUserBalance($userId, $_POST);
                    $success = 'User balance updated successfully';
                    break;
                case 'create_card':
                    $card = $this->createCardForUser($userId, $_POST);
                    $cardDetails = !empty($_POST['card_number']) ? "Manual card created" : "Auto-generated card created";
                    $success = $cardDetails . " successfully with balance: $" . number_format($card['balance'], 2);
                    break;
                case 'update_card_balance':
                    $this->updateCardBalance($_POST);
                    $success = 'Card balance updated successfully';
                    break;
                case 'delete_card':
                    $this->deleteCard($_POST);
                    $success = 'Card deleted successfully';
                    break;
                case 'toggle_card_status':
                    $cardId = intval($_POST['card_id']);
                    $userIdForCard = intval($_POST['user_id']);
                    $this->card->toggleStatus($cardId, $userIdForCard);
                    header('Location: ?page=admin&action=manage_user&id=' . $userId);
                    exit;
            }
        }
        
        include 'views/admin/manage_user.php';
    }

    private function updateUserBalance($userId, $data) {
        $amount = floatval($data['amount']);
        $type = $data['balance_type']; // 'add' or 'subtract'
        $description = $data['description'] ?? 'Admin balance adjustment';
        
        if ($type === 'subtract') {
            $amount = -$amount;
        }
        
        $this->user->updateBalance($userId, $amount);
        
        // Record transaction
        $this->transaction->create([
            'user_id' => $userId,
            'card_id' => null,
            'type' => 'account_topup',
            'amount' => $amount,
            'description' => $description . ' (Admin)'
        ]);
        // Send notification
        $user = $this->user->findById($userId);
        $this->emailService->sendAccountToppedUpEmail($user['email'], $user['name'], $amount, $user['balance']);
    }

    private function createCardForUser($userId, $data) {
        $amount = floatval($data['card_amount']);
        $cardType = $data['card_type'] ?? 'visa';
        
        // Check if manual details are provided
        $manualDetails = null;
        if (!empty($data['card_number']) && !empty($data['cvv']) && !empty($data['expiry_date'])) {
            $manualDetails = [
                'card_number' => $data['card_number'],
                'cvv' => $data['cvv'],
                'expiry_date' => $data['expiry_date'],
                'card_name' => $data['card_name'] ?? '',
                'zip_code' => $data['zip_code'] ?? '',
                'address' => $data['address'] ?? ''
            ];
        }
        
        // Create the card
        $card = $this->card->create($userId, $amount, $manualDetails);
        
        // Record transaction
        $this->transaction->create([
            'user_id' => $userId,
            'card_id' => $card['id'],
            'type' => 'card_purchase',
            'amount' => -$amount,
            'description' => 'Virtual card purchase (Admin)'
        ]);
        // Send notification
        $user = $this->user->findById($userId);
        $this->emailService->sendCardCreatedEmail($user['email'], $user['name'], $card);
        
        return $card;
    }

    public function recordTransaction() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=admin&action=users');
            exit;
        }

        $userId = intval($_POST['user_id']);
        $cardId = !empty($_POST['card_id']) ? intval($_POST['card_id']) : null;
        $type = $_POST['transaction_type'];
        $amount = floatval($_POST['transaction_amount']);
        $description = trim($_POST['transaction_description']);

        // Validation
        if (empty($description)) {
            $description = 'Admin transaction';
        }

        // Record the transaction
        $transactionId = $this->transaction->create([
            'user_id' => $userId,
            'card_id' => $cardId,
            'type' => $type,
            'amount' => $amount,
            'description' => $description . ' (Admin)'
        ]);

        // Update user balance if it's an account transaction
        if ($cardId === null) {
            $this->user->updateBalance($userId, $amount);
        } else {
            // Update card balance
            $this->card->updateBalance($cardId, $userId, $amount);
        }

        // Send notification
        $user = $this->user->findById($userId);
        $transaction = [
            'type' => $type,
            'amount' => $amount,
            'description' => $description . ' (Admin)'
        ];
        $this->emailService->sendTransactionRecordedEmail($user['email'], $user['name'], $transaction);

        // Redirect back to user management
        header('Location: ?page=admin&action=manage_user&id=' . $userId . '&success=transaction_recorded');
        exit;
    }

    private function updateCardBalance($data) {
        $cardId = intval($data['card_id']);
        $amount = floatval($data['card_amount']);
        $type = $data['card_balance_type']; // 'add' or 'subtract'
        $description = $data['card_description'] ?? 'Admin card balance adjustment';
        
        if ($type === 'subtract') {
            $amount = -$amount;
        }
        
        $this->card->updateBalance($cardId, $data['user_id'], $amount);
        
        // Record transaction
        $this->transaction->create([
            'user_id' => $data['user_id'],
            'card_id' => $cardId,
            'type' => 'card_load',
            'amount' => $amount,
            'description' => $description . ' (Admin)'
        ]);
        // Send notification
        $user = $this->user->findById($data['user_id']);
        $card = $this->card->findById($cardId, $data['user_id']);
        $this->emailService->sendCardToppedUpEmail($user['email'], $user['name'], $card, $amount, $card['balance']);
    }

    private function deleteCard($data) {
        $cardId = intval($data['card_id']);
        $userId = intval($data['user_id']);
        
        // Get card details before deletion for transaction record
        $card = $this->card->findById($cardId, $userId);
        if (!$card) {
            throw new Exception('Card not found');
        }
        
        // Delete the card
        $deleted = $this->card->deleteById($cardId);
        
        if ($deleted) {
            // Record transaction for card deletion
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => null, // Card is deleted, so no card_id
                'type' => 'card_deletion',
                'amount' => 0, // No amount change, just record the action
                'description' => 'Card deleted by admin - Card #' . $cardId . ' (Balance: $' . number_format($card['balance'], 2) . ')'
            ]);
            // Send notification
            $user = $this->user->findById($userId);
            $this->emailService->sendCardDeletedEmail($user['email'], $user['name'], $card);
        }
        
        return $deleted;
    }

    private function getStats() {
        return [
            'total_users' => $this->user->getTotalUsers(),
            'total_cards' => $this->card->getTotalCards(),
            'total_transactions' => $this->transaction->getTotalTransactions(),
            'total_balance' => $this->user->getTotalBalance(),
            'total_sales' => $this->card->getTotalSales()
        ];
    }

    // API endpoints for AJAX operations
    public function apiGetUser() {
        $userId = $_GET['id'] ?? 0;
        $user = $this->user->findById($userId);
        echo json_encode($user);
    }

    public function apiGetUserCards() {
        $userId = $_GET['user_id'] ?? 0;
        $cards = $this->card->findByUser($userId);
        echo json_encode($cards);
    }

    public function apiUpdateUserBalance() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = intval($_POST['user_id']);
        $amount = floatval($_POST['amount']);
        $type = $_POST['type'];
        $description = $_POST['description'] ?? 'Admin balance adjustment';

        if ($type === 'subtract') {
            $amount = -$amount;
        }

        try {
            $this->user->updateBalance($userId, $amount);
            
            // Record transaction
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => null,
                'type' => 'account_topup',
                'amount' => $amount,
                'description' => $description . ' (Admin)'
            ]);

            echo json_encode(['success' => true, 'message' => 'Balance updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to update balance']);
        }
    }

    public function apiCreateCard() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = intval($_POST['user_id']);
        $amount = floatval($_POST['amount']);

        try {
            $card = $this->card->create($userId, $amount);
            
            // Record transaction
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => $card['id'],
                'type' => 'card_purchase',
                'amount' => -$amount,
                'description' => 'Virtual card purchase (Admin)'
            ]);

            echo json_encode(['success' => true, 'card' => $card, 'message' => 'Card created successfully']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to create card']);
        }
    }

    public function apiUpdateCardBalance() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $cardId = intval($_POST['card_id']);
        $userId = intval($_POST['user_id']);
        $amount = floatval($_POST['amount']);
        $type = $_POST['type'];
        $description = $_POST['description'] ?? 'Admin card balance adjustment';

        if ($type === 'subtract') {
            $amount = -$amount;
        }

        try {
            $this->card->updateBalance($cardId, $userId, $amount);
            
            // Record transaction
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => $cardId,
                'type' => 'card_load',
                'amount' => $amount,
                'description' => $description . ' (Admin)'
            ]);

            echo json_encode(['success' => true, 'message' => 'Card balance updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to update card balance']);
        }
    }

    public function marketingCampaigns() {
        // List all campaigns
        $db = Database::getInstance();
        $campaigns = $db->query('SELECT * FROM campaigns ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
        include 'views/admin/marketing_campaigns.php';
    }

    public function createMarketingCampaign() {
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = trim($_POST['subject'] ?? '');
            $html_body = trim($_POST['html_body'] ?? '');
            $text_body = trim($_POST['text_body'] ?? '');
            $segment = $_POST['segment'] ?? 'all';
            $scheduled_at = $_POST['scheduled_at'] ?? '';
            $send_now = !empty($_POST['send_now']);
            if (empty($subject) || empty($html_body) || (!$send_now && empty($scheduled_at))) {
                $error = 'Subject, HTML body, and scheduled time are required.';
            } else {
                $db = Database::getInstance();
                $status = $send_now ? 'sent' : 'scheduled';
                $sent_at = $send_now ? date('Y-m-d H:i:s') : null;
                $stmt = $db->query('INSERT INTO campaigns (subject, html_body, text_body, segment, scheduled_at, status, sent_at) VALUES (?, ?, ?, ?, ?, ?, ?)', [
                    $subject, $html_body, $text_body, $segment, $scheduled_at, $status, $sent_at
                ]);
                $campaign_id = $db->lastInsertId();
                if ($stmt) {
                    if ($send_now) {
                        // Send campaign immediately
                        $campaign = $db->query('SELECT * FROM campaigns WHERE id = ?', [$campaign_id])->fetch(PDO::FETCH_ASSOC);
                        $users = ($segment === 'all')
                            ? $db->query('SELECT id, name, email FROM users')->fetchAll(PDO::FETCH_ASSOC)
                            : $db->query('SELECT DISTINCT u.id, u.name, u.email FROM users u JOIN cards c ON u.id = c.user_id')->fetchAll(PDO::FETCH_ASSOC);
                        $emailService = new EmailService();
                        $emailService->sendCampaignToUsers($campaign, $users);
                        $success = 'Campaign sent successfully!';
                    } else {
                        $success = 'Campaign scheduled successfully!';
                    }
                    header('Location: ?page=admin&action=view_campaign&id=' . $campaign_id . '&success=1');
                    exit;
                } else {
                    $error = 'Failed to schedule campaign.';
                }
            }
        }
        include 'views/admin/create_marketing_campaign.php';
    }

    public function viewCampaign() {
        $db = Database::getInstance();
        $id = intval($_GET['id'] ?? 0);
        $campaign = $db->query('SELECT * FROM campaigns WHERE id = ?', [$id])->fetch(PDO::FETCH_ASSOC);
        $recipients = $db->query('SELECT cr.*, u.email, u.name FROM campaign_recipients cr JOIN users u ON cr.user_id = u.id WHERE cr.campaign_id = ?', [$id])->fetchAll(PDO::FETCH_ASSOC);
        include 'views/admin/view_campaign.php';
    }

    public function sendCampaignNow() {
        $db = Database::getInstance();
        $id = intval($_GET['id'] ?? 0);
        $campaign = $db->query('SELECT * FROM campaigns WHERE id = ?', [$id])->fetch(PDO::FETCH_ASSOC);
        if ($campaign && $campaign['status'] === 'scheduled') {
            $users = ($campaign['segment'] === 'all')
                ? $db->query('SELECT id, name, email FROM users')->fetchAll(PDO::FETCH_ASSOC)
                : $db->query('SELECT DISTINCT u.id, u.name, u.email FROM users u JOIN cards c ON u.id = c.user_id')->fetchAll(PDO::FETCH_ASSOC);
            $emailService = new EmailService();
            $emailService->sendCampaignToUsers($campaign, $users);
            $db->query('UPDATE campaigns SET status = ?, sent_at = NOW() WHERE id = ?', ['sent', $id]);
        }
        header('Location: ?page=admin&action=view_campaign&id=' . $id . '&success=1');
        exit;
    }

}
?>