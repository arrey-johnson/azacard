<?php

class HomeController {
    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ?page=dashboard');
            exit;
        }
        
        include 'views/home.php';
    }
}
?>