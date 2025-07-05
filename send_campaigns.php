<?php
// Script to send scheduled marketing campaigns
require_once __DIR__ . '/app/EmailService.php';
require_once __DIR__ . '/app/Database.php';
require_once __DIR__ . '/app/User.php';

$db = new Database();
$emailService = new EmailService();
$userModel = new User();

// Get all campaigns scheduled to be sent and not yet sent
$campaigns = $db->query('SELECT * FROM campaigns WHERE status = ? AND scheduled_at <= NOW()', ['scheduled'])->fetchAll(PDO::FETCH_ASSOC);

foreach ($campaigns as $campaign) {
    // Select users by segment
    if ($campaign['segment'] === 'all') {
        $users = $db->query('SELECT id, name, email FROM users')->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($campaign['segment'] === 'card_owners') {
        $users = $db->query('SELECT DISTINCT u.id, u.name, u.email FROM users u JOIN cards c ON u.id = c.user_id')->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $users = [];
    }
    if (!empty($users)) {
        $emailService->sendCampaignToUsers($campaign, $users);
    } else {
        // Mark as sent with no recipients
        $db->query('UPDATE campaigns SET status = ?, sent_at = NOW() WHERE id = ?', ['sent', $campaign['id']]);
    }
} 