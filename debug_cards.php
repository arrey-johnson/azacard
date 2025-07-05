<?php
// Debug script to test card retrieval
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'google_cards');
define('DB_USER', 'root');
define('DB_PASS', '');

// Include required files
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/Card.php';

// Test database connection
$db = Database::getInstance();
echo "Database connection: " . ($db ? "SUCCESS" : "FAILED") . "\n";

// Test user retrieval
$user = new User();
$users = $user->getAllUsers();
echo "Total users: " . count($users) . "\n";

foreach ($users as $u) {
    echo "User ID: " . $u['id'] . ", Name: " . $u['name'] . ", Email: " . $u['email'] . "\n";
}

// Test card retrieval for each user
$card = new Card();
foreach ($users as $u) {
    $userCards = $card->findByUser($u['id']);
    echo "User " . $u['id'] . " (" . $u['name'] . ") has " . count($userCards) . " cards\n";
    
    foreach ($userCards as $c) {
        echo "  - Card ID: " . $c['id'] . ", Number: " . substr($c['card_number'], 0, 4) . "****, Balance: $" . $c['balance'] . "\n";
    }
}

// Test direct database query
$sql = "SELECT c.*, u.name as user_name FROM cards c LEFT JOIN users u ON c.user_id = u.id";
$result = $db->fetchAll($sql);
echo "\nDirect database query - Total cards: " . count($result) . "\n";

foreach ($result as $r) {
    echo "Card ID: " . $r['id'] . ", User: " . $r['user_name'] . ", Number: " . substr($r['card_number'], 0, 4) . "****\n";
}
?> 