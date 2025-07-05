<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;
    
    public function __construct() {
        require_once __DIR__ . '/../vendor/autoload.php';
        
        $this->mailer = new PHPMailer(true);
        $this->mailer->CharSet = 'UTF-8';
        $this->setupSMTP();
    }
    
    private function setupSMTP() {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host       = 'mail.zapkard.shop';
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = 'support@zapkard.shop';
            $this->mailer->Password   = '@support237';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mailer->Port       = 465;
            
            $this->mailer->setFrom('support@zapkard.shop', 'ZapKard Support');
            $this->mailer->isHTML(true);
        } catch (Exception $e) {
            error_log("Email setup failed: " . $e->getMessage());
        }
    }
    
    public function sendWelcomeEmail($userEmail, $userName, $username = null) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            
            // Create personalized subject with username if available
            $subject = $username ? "Welcome to ZapKard, @$username! 🎉" : "Welcome to ZapKard! 🎉";
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            
            $this->mailer->Body = $this->getWelcomeEmailTemplate($userName, $username);
            $this->mailer->AltBody = $this->getWelcomeEmailText($userName, $username);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Welcome email failed for $userEmail: " . $e->getMessage());
            return false;
        }
    }
    
    public function sendPasswordResetEmail($userEmail, $userName, $resetLink) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $resetSubject = 'Reset Your ZapKard Password';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($resetSubject) . '?=';
            $this->mailer->Body = $this->getPasswordResetTemplate($userName, $resetLink);
            $this->mailer->AltBody = $this->getPasswordResetText($userName, $resetLink);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Password reset email failed for $userEmail: " . $e->getMessage());
            return false;
        }
    }
    
    private function getWelcomeEmailTemplate($userName, $username = null) {
        $usernameDisplay = $username ? "@$username" : '';
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome to ZapKard</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { text-align: center; padding: 30px 0; background: linear-gradient(135deg, #4285F4, #34A853); border-radius: 10px; margin-bottom: 30px; }
                .logo { font-size: 32px; font-weight: bold; color: white; margin-bottom: 10px; }
                .logo span:nth-child(1) { color: #4285F4; }
                .logo span:nth-child(2) { color: #EA4335; }
                .logo span:nth-child(3) { color: #FBBC04; }
                .logo span:nth-child(4) { color: #4285F4; }
                .logo span:nth-child(5) { color: #34A853; }
                .logo span:nth-child(6) { color: #EA4335; }
                .logo span:nth-child(7) { color: #FBBC04; }
                .subtitle { color: white; font-size: 18px; opacity: 0.9; }
                .content { background: #f9f9f9; padding: 30px; border-radius: 10px; margin-bottom: 20px; }
                .welcome-text { font-size: 24px; color: #333; margin-bottom: 20px; }
                .username-display { font-size: 18px; color: #4285F4; font-weight: bold; margin-bottom: 15px; font-family: monospace; }
                .features { margin: 30px 0; }
                .feature { display: flex; align-items: center; margin-bottom: 15px; }
                .feature-icon { width: 30px; height: 30px; background: #4285F4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-weight: bold; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #4285F4, #34A853); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
                .social-links { margin: 20px 0; }
                .social-links a { display: inline-block; margin: 0 10px; color: #4285F4; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo">
                        <span>Z</span><span>a</span><span>p</span><span>K</span><span>a</span><span>r</span><span>d</span>
                    </div>
                    <div class="subtitle">Your Digital Payment Solution</div>
                </div>
                
                <div class="content">
                    <div class="welcome-text">Welcome to ZapKard, ' . htmlspecialchars($userName) . '! 🎉</div>
                    ' . ($username ? '<div class="username-display">Your username: ' . htmlspecialchars($usernameDisplay) . '</div>' : '') . '
                    
                    <p>Thank you for joining ZapKard! We\'re excited to have you as part of our community. You now have access to our comprehensive virtual card platform.</p>
                    
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon">💳</div>
                            <div>
                                <strong>Virtual Cards</strong><br>
                                Create and manage virtual cards instantly
                            </div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">🔒</div>
                            <div>
                                <strong>Secure Transactions</strong><br>
                                Bank-level security for all your payments
                            </div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">⚡</div>
                            <div>
                                <strong>Instant Loading</strong><br>
                                Add funds to your cards in seconds
                            </div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">📊</div>
                            <div>
                                <strong>Real-time Tracking</strong><br>
                                Monitor your spending and balance
                            </div>
                        </div>
                    </div>
                    
                    <p><strong>Getting Started:</strong></p>
                    <ol>
                        <li>Complete your profile setup</li>
                        <li>Add funds to your account</li>
                        <li>Create your first virtual card</li>
                        <li>Start making secure payments</li>
                    </ol>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="https://zapkard.shop" class="cta-button">Access Your Dashboard</a>
                    </div>
                </div>
                
                <div class="footer">
                    <p><strong>Need Help?</strong></p>
                    <p>Our support team is here to help you get started. Contact us at support@zapkard.shop</p>
                    
                    <div class="social-links">
                        <a href="#">Website</a> |
                        <a href="#">Support</a> |
                        <a href="#">Privacy Policy</a> |
                        <a href="#">Terms of Service</a>
                    </div>
                    
                    <p style="margin-top: 20px; font-size: 12px; color: #999;">
                        This email was sent to you because you created an account with ZapKard.<br>
                        If you didn\'t create this account, please contact our support team immediately.
                    </p>
                </div>
            </div>
        </body>
        </html>';
    }
    
    private function getWelcomeEmailText($userName, $username = null) {
        $usernameInfo = $username ? "\nYour username: @$username" : '';
        return "Welcome to ZapKard, $userName!$usernameInfo

Thank you for joining ZapKard! We're excited to have you as part of our community. You now have access to our comprehensive virtual card platform.

What you can do with ZapKard:
• Create and manage virtual cards instantly
• Make secure transactions with bank-level security
• Add funds to your cards in seconds
• Monitor your spending and balance in real-time

Getting Started:
1. Complete your profile setup
2. Add funds to your account
3. Create your first virtual card
4. Start making secure payments

Access your dashboard: https://zapkard.shop

Need Help?
Our support team is here to help you get started. Contact us at support@zapkard.shop

Best regards,
The ZapKard Team";
    }
    
    private function getPasswordResetTemplate($userName, $resetLink) {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Your Password - ZapKard</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { text-align: center; padding: 30px 0; background: linear-gradient(135deg, #4285F4, #34A853); border-radius: 10px; margin-bottom: 30px; }
                .logo { font-size: 32px; font-weight: bold; color: white; margin-bottom: 10px; }
                .logo span:nth-child(1) { color: #4285F4; }
                .logo span:nth-child(2) { color: #EA4335; }
                .logo span:nth-child(3) { color: #FBBC04; }
                .logo span:nth-child(4) { color: #4285F4; }
                .logo span:nth-child(5) { color: #34A853; }
                .logo span:nth-child(6) { color: #EA4335; }
                .logo span:nth-child(7) { color: #FBBC04; }
                .subtitle { color: white; font-size: 18px; opacity: 0.9; }
                .content { background: #f9f9f9; padding: 30px; border-radius: 10px; margin-bottom: 20px; }
                .reset-text { font-size: 24px; color: #333; margin-bottom: 20px; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #4285F4, #34A853); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
                .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo">
                        <span>Z</span><span>a</span><span>p</span><span>K</span><span>a</span><span>r</span><span>d</span>
                    </div>
                    <div class="subtitle">Your Digital Payment Solution</div>
                </div>
                
                <div class="content">
                    <div class="reset-text">Reset Your Password</div>
                    
                    <p>Hello ' . htmlspecialchars($userName) . ',</p>
                    
                    <p>We received a request to reset your ZapKard account password. If you made this request, click the button below to create a new password:</p>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . htmlspecialchars($resetLink) . '" class="cta-button">Reset Password</a>
                    </div>
                    
                    <p>If the button doesn\'t work, copy and paste this link into your browser:</p>
                    <p style="word-break: break-all; color: #4285F4;">' . htmlspecialchars($resetLink) . '</p>
                    
                    <div class="warning">
                        <strong>⚠️ Security Notice:</strong>
                        <ul>
                            <li>This link will expire in 1 hour</li>
                            <li>If you didn\'t request this password reset, please ignore this email</li>
                            <li>Never share your password or this link with anyone</li>
                        </ul>
                    </div>
                    
                    <p>If you have any questions or need assistance, please contact our support team at support@zapkard.shop</p>
                </div>
                
                <div class="footer">
                    <p><strong>Need Help?</strong></p>
                    <p>Our support team is here to help. Contact us at support@zapkard.shop</p>
                    
                    <p style="margin-top: 20px; font-size: 12px; color: #999;">
                        This email was sent to you because you requested a password reset for your ZapKard account.<br>
                        If you didn\'t request this, please contact our support team immediately.
                    </p>
                </div>
            </div>
        </body>
        </html>';
    }
    
    private function getPasswordResetText($userName, $resetLink) {
        return "Reset Your ZapKard Password

Hello $userName,

We received a request to reset your ZapKard account password. If you made this request, use the link below to create a new password:

$resetLink

⚠️ Security Notice:
• This link will expire in 1 hour
• If you didn't request this password reset, please ignore this email
• Never share your password or this link with anyone

If you have any questions or need assistance, please contact our support team at support@zapkard.shop

Best regards,
The ZapKard Team";
    }

    /**
     * Notify user when admin creates a card for them
     */
    public function sendCardCreatedEmail($userEmail, $userName, $cardInfo) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $subject = 'A new virtual card has been created for you!';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $masked = substr($cardInfo['card_number'], 0, 4) . ' **** **** ' . substr($cardInfo['card_number'], -4);
            $this->mailer->Body = '<p>Dear ' . htmlspecialchars($userName) . ',</p>'
                . '<p>A new virtual card has been created for you by the admin.</p>'
                . '<ul>'
                . '<li><b>Card Number:</b> ' . $masked . '</li>'
                . '<li><b>Expiry:</b> ' . htmlspecialchars($cardInfo['expiry_date']) . '</li>'
                . '<li><b>Status:</b> ' . ($cardInfo['is_active'] ? 'Active' : 'Inactive') . '</li>'
                . '</ul>'
                . '<p>You can view and manage your card in your ZapKard dashboard.</p>';
            $this->mailer->AltBody = "A new virtual card has been created for you. Card: $masked, Expiry: {$cardInfo['expiry_date']}.";
            $this->mailer->send();
        } catch (Exception $e) { error_log("Card created email failed: " . $e->getMessage()); }
    }

    /**
     * Notify user when admin tops up their card
     */
    public function sendCardToppedUpEmail($userEmail, $userName, $cardInfo, $amount, $newBalance) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $subject = 'Your virtual card has been topped up!';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $masked = substr($cardInfo['card_number'], 0, 4) . ' **** **** ' . substr($cardInfo['card_number'], -4);
            $this->mailer->Body = '<p>Dear ' . htmlspecialchars($userName) . ',</p>'
                . '<p>Your virtual card has been topped up by the admin.</p>'
                . '<ul>'
                . '<li><b>Card Number:</b> ' . $masked . '</li>'
                . '<li><b>Amount:</b> $' . number_format($amount, 2) . '</li>'
                . '<li><b>New Balance:</b> $' . number_format($newBalance, 2) . '</li>'
                . '</ul>'
                . '<p>You can view your updated card balance in your dashboard.</p>';
            $this->mailer->AltBody = "Your card $masked has been topped up by $amount. New balance: $newBalance.";
            $this->mailer->send();
        } catch (Exception $e) { error_log("Card top-up email failed: " . $e->getMessage()); }
    }

    /**
     * Notify user when admin tops up their account balance
     */
    public function sendAccountToppedUpEmail($userEmail, $userName, $amount, $newBalance) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $subject = 'Your account balance has been topped up!';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $this->mailer->Body = '<p>Dear ' . htmlspecialchars($userName) . ',</p>'
                . '<p>Your account balance has been topped up by the admin.</p>'
                . '<ul>'
                . '<li><b>Amount:</b> $' . number_format($amount, 2) . '</li>'
                . '<li><b>New Balance:</b> $' . number_format($newBalance, 2) . '</li>'
                . '</ul>'
                . '<p>You can view your updated account balance in your dashboard.</p>';
            $this->mailer->AltBody = "Your account has been topped up by $amount. New balance: $newBalance.";
            $this->mailer->send();
        } catch (Exception $e) { error_log("Account top-up email failed: " . $e->getMessage()); }
    }

    /**
     * Notify user when admin deletes their card
     */
    public function sendCardDeletedEmail($userEmail, $userName, $cardInfo) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $subject = 'A virtual card has been deleted from your account';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $masked = substr($cardInfo['card_number'], 0, 4) . ' **** **** ' . substr($cardInfo['card_number'], -4);
            $this->mailer->Body = '<p>Dear ' . htmlspecialchars($userName) . ',</p>'
                . '<p>A virtual card has been deleted from your account by the admin.</p>'
                . '<ul>'
                . '<li><b>Card Number:</b> ' . $masked . '</li>'
                . '<li><b>Expiry:</b> ' . htmlspecialchars($cardInfo['expiry_date']) . '</li>'
                . '</ul>'
                . '<p>If you have questions, please contact support.</p>';
            $this->mailer->AltBody = "A card $masked has been deleted from your account.";
            $this->mailer->send();
        } catch (Exception $e) { error_log("Card deleted email failed: " . $e->getMessage()); }
    }

    /**
     * Notify user when admin records a card or account transaction
     */
    public function sendTransactionRecordedEmail($userEmail, $userName, $transaction) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $subject = 'A transaction has been recorded on your account';
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $desc = htmlspecialchars($transaction['description']);
            $amount = number_format($transaction['amount'], 2);
            $type = ucfirst(str_replace('_', ' ', $transaction['type']));
            $this->mailer->Body = '<p>Dear ' . htmlspecialchars($userName) . ',</p>'
                . '<p>A transaction has been recorded on your account by the admin.</p>'
                . '<ul>'
                . '<li><b>Type:</b> ' . $type . '</li>'
                . '<li><b>Amount:</b> $' . $amount . '</li>'
                . '<li><b>Description:</b> ' . $desc . '</li>'
                . '</ul>'
                . '<p>You can view your transaction history in your dashboard.</p>';
            $this->mailer->AltBody = "A $type transaction of $amount has been recorded: $desc.";
            $this->mailer->send();
        } catch (Exception $e) { error_log("Transaction recorded email failed: " . $e->getMessage()); }
    }

    /**
     * Send a marketing email to a single user
     */
    public function sendMarketingEmail($userEmail, $userName, $subject, $htmlBody, $textBody = null) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($userEmail, $userName);
            $this->mailer->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $this->mailer->Body = $htmlBody;
            $this->mailer->AltBody = $textBody ?: strip_tags($htmlBody);
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Marketing email failed for $userEmail: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a campaign to a list of users and log status
     */
    public function sendCampaignToUsers($campaign, $users) {
        $db = Database::getInstance();
        foreach ($users as $user) {
            $success = $this->sendMarketingEmail($user['email'], $user['name'], $campaign['subject'], $campaign['html_body'], $campaign['text_body']);
            $status = $success ? 'sent' : 'failed';
            $db->query('INSERT INTO campaign_recipients (campaign_id, user_id, sent_status, sent_at) VALUES (?, ?, ?, NOW())', [
                $campaign['id'], $user['id'], $status
            ]);
        }
        // Mark campaign as sent
        $db->query('UPDATE campaigns SET status = ?, sent_at = NOW() WHERE id = ?', ['sent', $campaign['id']]);
    }
}
?>