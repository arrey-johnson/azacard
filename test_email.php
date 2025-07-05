<?php
// Test script to send welcome email to existing user
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/EmailService.php';

// Start session to access current user
session_start();

echo "<h2>ZapKard Email Test</h2>";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>No user logged in. Please log in first.</p>";
    echo "<p><a href='?page=login'>Go to Login</a></p>";
    exit;
}

$user = new User();
$currentUser = $user->findById($_SESSION['user_id']);

if (!$currentUser) {
    echo "<p style='color: red;'>Current user not found in database.</p>";
    exit;
}

echo "<p><strong>Current User:</strong></p>";
echo "<ul>";
echo "<li>Name: " . htmlspecialchars($currentUser['name']) . "</li>";
echo "<li>Email: " . htmlspecialchars($currentUser['email']) . "</li>";
echo "<li>User ID: " . $currentUser['id'] . "</li>";
echo "</ul>";

// Test email sending
echo "<h3>Testing Email Sending...</h3>";

        try {
            $emailService = new EmailService();
            $result = $emailService->sendWelcomeEmail($currentUser['email'], $currentUser['name'], $currentUser['username'] ?? null);
            
            if ($result) {
                echo "<p style='color: green;'>✅ Welcome email sent successfully to " . htmlspecialchars($currentUser['email']) . "</p>";
                echo "<p>Check your email inbox (and spam folder) for the welcome email.</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to send welcome email.</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error sending email: " . htmlspecialchars($e->getMessage()) . "</p>";
        }

echo "<br><p><a href='?page=dashboard'>← Back to Dashboard</a></p>";
?> 