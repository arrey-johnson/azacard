<?php
// Direct email test script - can be used to test with any email address
require_once 'app/EmailService.php';

echo "<h2>ZapKard Direct Email Test</h2>";

// Check if email parameter is provided
$testEmail = $_GET['email'] ?? '';
$testName = $_GET['name'] ?? 'Test User';
$testUsername = $_GET['username'] ?? 'testuser';

if (empty($testEmail)) {
    echo "<p>To test email sending, add ?email=your-email@example.com to the URL</p>";
    echo "<p>Example: <a href='?email=test@example.com'>test_email_direct.php?email=test@example.com</a></p>";
    echo "<p>You can also add &username=yourusername to test with a specific username</p>";
    exit;
}

echo "<p><strong>Testing Email:</strong></p>";
echo "<ul>";
echo "<li>Name: " . htmlspecialchars($testName) . "</li>";
echo "<li>Username: @" . htmlspecialchars($testUsername) . "</li>";
echo "<li>Email: " . htmlspecialchars($testEmail) . "</li>";
echo "</ul>";

// Test email sending
echo "<h3>Testing Email Sending...</h3>";

        try {
            $emailService = new EmailService();
            $result = $emailService->sendWelcomeEmail($testEmail, $testName, $testUsername);
            
            if ($result) {
                echo "<p style='color: green;'>✅ Welcome email sent successfully to " . htmlspecialchars($testEmail) . "</p>";
                echo "<p>Check your email inbox (and spam folder) for the welcome email.</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to send welcome email.</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error sending email: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>Error Details:</strong></p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        }

echo "<br><p><a href='?page=dashboard'>← Back to Dashboard</a></p>";
?> 