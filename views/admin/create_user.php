<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - ZapKard Admin</title>
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
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-google-blue to-google-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl font-medium">
                        <span style="color: #4285F4 !important;">Z</span><span style="color: #EA4335 !important;">a</span><span style="color: #FBBC05 !important;">p</span><span style="color: #4285F4 !important;">K</span><span style="color: #34A853 !important;">a</span><span style="color: #EA4335 !important;">r</span><span style="color: #FBBC05 !important;">d</span>
                        <span class="text-sm text-gray-500 ml-2">Admin Panel</span>
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="?page=admin&action=users" class="text-gray-600 hover:text-google-blue font-medium transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Users
                    </a>
                    <a href="?page=admin-logout" class="bg-google-red hover-bg-google-red text-white px-4 py-2 rounded-lg transition duration-200 font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Admin Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex space-x-8">
                <a href="?page=admin" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="?page=admin&action=users" class="py-4 px-2 border-b-2 border-google-blue text-google-blue font-medium">
                    <i class="fas fa-users mr-2"></i>Users
                </a>
                <a href="?page=admin&action=cards" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-credit-card mr-2"></i>Cards
                </a>
                <a href="?page=admin&action=transactions" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-history mr-2"></i>Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Create User</h1>
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-light text-gray-900">Create New User</h2>
                <p class="text-gray-600 mt-2">Create a new user account with optional initial balance and card generation.</p>
            </div>

            <!-- Create User Form -->
            <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                <?php if (!empty($error)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="?page=admin&action=create_user">
                    <!-- User Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user mr-3 text-google-blue"></i>User Information
                        </h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Enter full name"
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            </div>
                            
                            <div>
                                <label for="username" class="block text-gray-700 font-medium mb-2">Username *</label>
                                <input type="text" id="username" name="username" required pattern="[a-zA-Z0-9_]{3,20}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Choose username (3-20 chars)"
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                                <p class="text-xs text-gray-500 mt-1">Letters, numbers, and underscores only</p>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Enter email address"
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Enter phone number"
                                       value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                            </div>
                            
                            <div>
                                <label for="password" class="block text-gray-700 font-medium mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="Enter password">
                                    <button type="button" onclick="togglePassword()" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="passwordToggle" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Initial Balance -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-wallet mr-3 text-google-green"></i>Initial Balance
                        </h3>
                        
                        <div>
                            <label for="initial_balance" class="block text-gray-700 font-medium mb-2">Account Balance</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number" id="initial_balance" name="initial_balance" step="0.01" min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="0.00"
                                       value="<?php echo htmlspecialchars($_POST['initial_balance'] ?? '0'); ?>">
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Leave as 0 if no initial balance is needed.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="?page=admin&action=users" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-6 rounded-lg transition duration-200">
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-6 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create User
                        </button>
                    </div>
                </form>
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