<?php

class DashboardController {
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
        $transactions = $this->transaction->findByUser($userId, 10);
        
        include 'views/dashboard.php';
    }
}
?>