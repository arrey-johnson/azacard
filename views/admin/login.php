<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ZapKard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .google-blue { color: #4285F4 !important; }
        .google-red { color: #EA4335 !important; }
        .google-yellow { color: #FBBC04 !important; }
        .google-green { color: #34A853 !important; }
        .bg-google-blue { background-color: #4285F4; }
        .bg-google-red { background-color: #EA4335; }
        .bg-google-yellow { background-color: #FBBC04; }
        .bg-google-green { background-color: #34A853; }
        .hover-bg-google-blue:hover { background-color: #3367D6; }
        .hover-bg-google-red:hover { background-color: #D93025; }
        .hover-bg-google-yellow:hover { background-color: #F9AB00; }
        .hover-bg-google-green:hover { background-color: #137333; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 max-w-md mx-auto">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-google-blue to-google-green rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-medium text-gray-900 mb-2">
                    <span style="color: #4285F4 !important;">Z</span><span style="color: #EA4335 !important;">a</span><span style="color: #FBBC05 !important;">p</span><span style="color: #4285F4 !important;">K</span><span style="color: #34A853 !important;">a</span><span style="color: #EA4335 !important;">r</span><span style="color: #4285F4 !important;">d</span>
                    <span class="text-gray-900">Cards</span>
                </h1>
                <p class="text-gray-600">Administrator Access</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-2xl font-medium text-gray-900 mb-6 text-center">Admin Login</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="?page=admin-login">
                    <div class="mb-6">
                        <label for="username" class="block text-gray-700 font-medium mb-2">Username or Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="username" name="username" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent"
                                   placeholder="Enter your username or email"
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent"
                                   placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="passwordToggle" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="?page=admin-forgot-password" class="text-google-blue hover:text-google-blue font-medium text-sm">
                        Forgot your password?
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <a href="?page=login" class="text-gray-600 hover:text-gray-800 font-medium text-sm">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to User Login
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    © 2024 ZapKard. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html> 