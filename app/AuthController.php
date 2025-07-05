<?php

use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = "Please fill in all fields";
            } else {
                $user = $this->user->authenticate($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    header('Location: ?page=dashboard');
                    exit;
                } else {
                    $error = "Invalid email or password";
                }
            }
        }
        
        include 'views/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($password)) {
                $error = "Please fill in all fields";
            } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
                $error = "Username must be 3-20 characters and contain only letters, numbers, and underscores";
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";
            } elseif (strlen($password) < 6) {
                $error = "Password must be at least 6 characters";
            } else {
                // Check if email already exists
                $existingUser = $this->user->findByEmail($email);
                if ($existingUser) {
                    $error = "Email already registered";
                } else {
                    // Check if username already exists
                    $existingUsername = $this->user->findByUsername($username);
                    if ($existingUsername) {
                        $error = "Username already taken";
                    } else {
                        $userId = $this->user->create([
                            'name' => $name,
                            'username' => $username,
                            'email' => $email,
                            'phone' => $phone,
                            'password' => $password
                        ]);
                    
                        // Send welcome email
                        try {
                            $emailService = new EmailService();
                            $emailService->sendWelcomeEmail($email, $name, $username);
                        } catch (Exception $e) {
                            // Log error but don't prevent registration
                            error_log("Welcome email failed for $email: " . $e->getMessage());
                        }
                        
                        $_SESSION['user_id'] = $userId;
                        $_SESSION['user_name'] = $name;
                        header('Location: ?page=dashboard');
                        exit;
                    }
                }
            }
        }
        
        include 'views/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: ?page=home');
        exit;
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (empty($email)) {
                $error = "Please enter your email address";
            } else {
                $user = $this->user->findByEmail($email);
                if ($user) {
                    // Generate reset token
                    $token = bin2hex(random_bytes(32));
                    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    
                    // Store reset token in database
                    $this->user->storeResetToken($user['id'], $token, $expires);
                    
                    // Send password reset email
                    try {
                        $emailService = new EmailService();
                        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/?page=reset-password&token=" . $token;
                        $emailService->sendPasswordResetEmail($user['email'], $user['name'], $resetLink);
                        $success = "Password reset link sent to your email address!";
                    } catch (Exception $e) {
                        // Log error but still show the reset link for demo purposes
                        error_log("Password reset email failed for {$user['email']}: " . $e->getMessage());
                        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/?page=reset-password&token=" . $token;
                        $success = "Password reset link sent! For demo purposes, click here: <a href='$resetLink' class='text-blue-600 underline'>Reset Password</a>";
                    }
                } else {
                    $error = "Email address not found";
                }
            }
        }
        
        include 'views/forgot-password.php';
    }

    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $error = "Invalid reset link";
            include 'views/reset-password.php';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($password) || empty($confirm_password)) {
                $error = "Please fill in all fields";
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";
            } elseif (strlen($password) < 6) {
                $error = "Password must be at least 6 characters";
            } else {
                // Verify token and update password
                $user = $this->user->findByResetToken($token);
                if ($user && $user['reset_expires'] > date('Y-m-d H:i:s')) {
                    $this->user->updatePassword($user['id'], $password);
                    $this->user->clearResetToken($user['id']);
                    $success = "Password updated successfully! You can now login with your new password.";
                } else {
                    $error = "Invalid or expired reset link";
                }
            }
        }
        
        include 'views/reset-password.php';
    }
}
?>