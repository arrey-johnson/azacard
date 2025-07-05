<?php
// Start session
session_start();

// Disable error display for production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Database configuration
require_once 'config.php';

// Include required files
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/Card.php';
require_once 'app/Transaction.php';
require_once 'app/AuthController.php';
require_once 'app/HomeController.php';
require_once 'app/DashboardController.php';
require_once 'app/CardController.php';
require_once 'app/AdminController.php';
require_once 'app/AdminAuthController.php';
require_once 'app/Admin.php';
require_once 'app/EmailService.php';

// Handle logout
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    $auth = new AuthController();
    $auth->logout();
}

// Contact form handler for home page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $contactName = trim($_POST['name']);
    $contactEmail = trim($_POST['email']);
    $contactMessage = trim($_POST['message']);
    $contactSuccess = '';
    $contactError = '';
    if ($contactName && $contactEmail && $contactMessage && filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
        try {
            $emailService = new EmailService();
            $subject = "ZapKard Contact Form Submission";
            $body = "<p><b>Name:</b> " . htmlspecialchars($contactName) . "</p>"
                  . "<p><b>Email:</b> " . htmlspecialchars($contactEmail) . "</p>"
                  . "<p><b>Message:</b><br>" . nl2br(htmlspecialchars($contactMessage)) . "</p>";
            $emailService->sendMarketingEmail('support@zapkard.shop', 'ZapKard Support', $subject, $body);
            $contactSuccess = 'Thank you for contacting us! We will get back to you soon.';
        } catch (Exception $e) {
            $contactError = 'Sorry, there was a problem sending your message. Please try again later.';
        }
    } else {
        $contactError = 'Please fill in all fields with a valid email address.';
    }
}

// Determine which page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'dashboard':
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;
    case 'forgot-password':
        $controller = new AuthController();
        $controller->forgotPassword();
        break;
    case 'reset-password':
        $controller = new AuthController();
        $controller->resetPassword();
        break;
    case 'cards':
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        $controller = new CardController();
        $controller->index();
        break;
    case 'buy-card':
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        $controller = new CardController();
        $controller->buy();
        break;
    case 'load-card':
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        $controller = new CardController();
        $controller->load();
        break;
    case 'check-balance':
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
        $controller = new CardController();
        $controller->checkBalance();
        break;
    case 'admin':
        $controller = new AdminController();
        $action = $_GET['action'] ?? 'index';
        
        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'users':
                $controller->users();
                break;
            case 'create_user':
                $controller->createUser();
                break;
            case 'record_transaction':
                $controller->recordTransaction();
                break;
            case 'cards':
                $controller->cards();
                break;
            case 'transactions':
                $controller->transactions();
                break;
            case 'marketing_campaigns':
                $controller->marketingCampaigns();
                break;
            case 'create_marketing_campaign':
                $controller->createMarketingCampaign();
                break;
            case 'manage_user':
                $controller->manageUser();
                break;
            case 'api_get_user':
                $controller->apiGetUser();
                break;
            case 'api_get_user_cards':
                $controller->apiGetUserCards();
                break;
            case 'api_update_user_balance':
                $controller->apiUpdateUserBalance();
                break;
            case 'api_create_card':
                $controller->apiCreateCard();
                break;
            case 'api_update_card_balance':
                $controller->apiUpdateCardBalance();
                break;
            case 'delete_card_global':
                $controller->deleteCardGlobal();
                break;
            case 'view_campaign':
                $controller->viewCampaign();
                break;
            case 'send_campaign_now':
                $controller->sendCampaignNow();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    case 'admin-login':
        $controller = new AdminAuthController();
        $controller->login();
        break;
    case 'admin-logout':
        $controller = new AdminAuthController();
        $controller->logout();
        break;
    case 'admin-forgot-password':
        $controller = new AdminAuthController();
        $controller->forgotPassword();
        break;
    case 'admin-reset-password':
        $controller = new AdminAuthController();
        $controller->resetPassword();
        break;
    case 'admin-change-password':
        $controller = new AdminAuthController();
        $controller->changePassword();
        break;
    default:
        require 'views/404.php';
        break;
}
?> 