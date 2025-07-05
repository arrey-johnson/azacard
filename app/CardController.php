<?php

class CardController {
    private $user;
    private $card;
    private $transaction;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        
        $this->user = new User();
        $this->card = new Card();
        $this->transaction = new Transaction();
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $user = $this->user->findById($userId);
        $cards = $this->card->findByUser($userId);
        include 'views/cards.php';
    }

    public function buy() {
        $userId = $_SESSION['user_id'];
        $user = $this->user->findById($userId);
        include 'views/buy-card.php';
    }

    public function load() {
        $userId = $_SESSION['user_id'];
        $user = $this->user->findById($userId);
        $cards = $this->card->findByUser($userId);
        include 'views/load-card.php';
    }

    public function checkBalance() {
        $userId = $_SESSION['user_id'];
        $user = $this->user->findById($userId);
        $cards = $this->card->findByUser($userId);
        include 'views/check-balance.php';
    }

    // API endpoints
    public function buyCard() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $amount = floatval($_POST['amount'] ?? 0);
        
        if ($amount <= 0) {
            echo json_encode(['error' => 'Invalid amount']);
            return;
        }

        $user = $this->user->findById($userId);
        if ($user['balance'] < $amount) {
            echo json_encode(['error' => 'Insufficient balance']);
            return;
        }

        try {
            // Create the card
            $card = $this->card->create($userId, $amount);
            
            // Deduct from user balance
            $this->user->updateBalance($userId, -$amount);
            
            // Record transaction
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => $card['id'],
                'type' => 'card_purchase',
                'amount' => -$amount,
                'description' => 'Virtual card purchase'
            ]);

            echo json_encode([
                'success' => true,
                'card' => $card,
                'message' => 'Card purchased successfully!'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to purchase card']);
        }
    }

    public function loadCard() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $cardId = intval($_POST['card_id'] ?? 0);
        $amount = floatval($_POST['amount'] ?? 0);
        
        if ($amount <= 0) {
            echo json_encode(['error' => 'Invalid amount']);
            return;
        }

        if (!$this->card->validateCard($cardId, $userId)) {
            echo json_encode(['error' => 'Invalid card']);
            return;
        }

        $user = $this->user->findById($userId);
        if ($user['balance'] < $amount) {
            echo json_encode(['error' => 'Insufficient balance']);
            return;
        }

        try {
            // Add to card balance
            $this->card->updateBalance($cardId, $userId, $amount);
            
            // Deduct from user balance
            $this->user->updateBalance($userId, -$amount);
            
            // Record transaction
            $this->transaction->create([
                'user_id' => $userId,
                'card_id' => $cardId,
                'type' => 'card_load',
                'amount' => -$amount,
                'description' => 'Card load'
            ]);

            $newBalance = $this->card->getBalance($cardId, $userId);
            
            echo json_encode([
                'success' => true,
                'new_balance' => $newBalance,
                'message' => 'Card loaded successfully!'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to load card']);
        }
    }

    public function getBalance() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $cardId = intval($_POST['card_id'] ?? 0);
        
        if (!$this->card->validateCard($cardId, $userId)) {
            echo json_encode(['error' => 'Invalid card']);
            return;
        }

        $balance = $this->card->getBalance($cardId, $userId);
        $card = $this->card->findById($cardId, $userId);
        
        echo json_encode([
            'success' => true,
            'balance' => $balance,
            'card_number' => $card['card_number'],
            'expiry_date' => $card['expiry_date']
        ]);
    }
}
?>