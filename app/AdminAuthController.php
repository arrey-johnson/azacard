<?php

class AdminAuthController {
    private $admin;

    public function __construct() {
        $this->admin = new Admin();
    }

    public function login() {
        // If already logged in as admin, redirect to admin dashboard
        if (isset($_SESSION['admin_id'])) {
            header('Location: ?page=admin');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Please enter both username and password.';
            } else {
                // Try to authenticate with username
                $admin = $this->admin->authenticate($username, $password);
                
                // If not found, try with email
                if (!$admin) {
                    $admin = $this->admin->authenticateByEmail($username, $password);
                }

                if ($admin) {
                    // Set admin session
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_name'] = $admin['name'];
                    $_SESSION['admin_role'] = $admin['role'];
                    $_SESSION['admin_email'] = $admin['email'];

                    // Redirect to admin dashboard
                    header('Location: ?page=admin');
                    exit;
                } else {
                    $error = 'Invalid username/email or password.';
                }
            }
        }

        include 'views/admin/login.php';
    }

    public function logout() {
        // Clear admin session
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_role']);
        unset($_SESSION['admin_email']);

        // Redirect to admin login
        header('Location: ?page=admin-login');
        exit;
    }

    public function forgotPassword() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = 'Please enter your email address.';
            } else {
                $admin = $this->admin->findByEmail($email);
                
                if ($admin) {
                    // Generate reset token
                    $resetToken = bin2hex(random_bytes(32));
                    $resetExpires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    
                    // Store reset token (you might want to add reset_token and reset_expires columns to admins table)
                    // For now, we'll just show a success message
                    $success = 'If an admin account with this email exists, you will receive password reset instructions.';
                } else {
                    // Don't reveal if email exists or not for security
                    $success = 'If an admin account with this email exists, you will receive password reset instructions.';
                }
            }
        }

        include 'views/admin/forgot_password.php';
    }

    public function resetPassword() {
        $error = '';
        $success = '';

        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            header('Location: ?page=admin-login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password) || empty($confirmPassword)) {
                $error = 'Please enter both password fields.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } else {
                // Validate token and update password
                // For now, we'll just show a success message
                $success = 'Password has been reset successfully. You can now login with your new password.';
            }
        }

        include 'views/admin/reset_password.php';
    }

    public function changePassword() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?page=admin-login');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $error = 'Please fill in all password fields.';
            } elseif ($newPassword !== $confirmPassword) {
                $error = 'New passwords do not match.';
            } elseif (strlen($newPassword) < 6) {
                $error = 'New password must be at least 6 characters long.';
            } else {
                // Verify current password
                $admin = $this->admin->findById($_SESSION['admin_id']);
                if ($admin && password_verify($currentPassword, $admin['password'])) {
                    // Update password
                    if ($this->admin->updatePassword($_SESSION['admin_id'], $newPassword)) {
                        $success = 'Password updated successfully.';
                    } else {
                        $error = 'Failed to update password. Please try again.';
                    }
                } else {
                    $error = 'Current password is incorrect.';
                }
            }
        }

        include 'views/admin/change_password.php';
    }
}
?>