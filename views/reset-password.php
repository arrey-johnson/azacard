<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ZapKard</title>
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
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-xl p-0 border border-gray-100 overflow-hidden">
            <!-- Google Color Accent Bar -->
            <div class="h-2 w-full" style="background: linear-gradient(90deg, #4285F4 0%, #EA4335 33%, #FBBC05 66%, #34A853 100%);"></div>
            <!-- Header -->
            <div class="text-center pt-6 sm:pt-8 pb-4 sm:pb-6 px-6 sm:px-8">
                <div class="flex items-center justify-center mb-3 sm:mb-4">
                    <svg width="36" height="36" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="sm:w-11 sm:h-11">
                        <rect width="44" height="44" rx="12" fill="url(#gbar)"/>
                        <defs>
                            <linearGradient id="gbar" x1="0" y1="0" x2="44" y2="44" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#4285F4"/>
                                <stop offset="0.33" stop-color="#EA4335"/>
                                <stop offset="0.66" stop-color="#FBBC05"/>
                                <stop offset="1" stop-color="#34A853"/>
                            </linearGradient>
                        </defs>
                        <g>
                            <path d="M13 22h18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M22 13v18" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </g>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-medium mb-2">
                    <span style="color: #4285F4;">G</span><span style="color: #EA4335;">o</span><span style="color: #FBBC05;">o</span><span style="color: #4285F4;">g</span><span style="color: #34A853;">l</span><span style="color: #EA4335;">e</span>
                    <span class="text-gray-900">Cards</span>
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">Set your new password</p>
                <p class="text-xs text-gray-500 mt-1">ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.</p>
            </div>

            <!-- Success Message -->
            <?php if (isset($success)): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 p-3 sm:p-4 rounded-lg mx-4 sm:mx-6 mb-3 sm:mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 sm:mr-3"></i>
                        <span class="text-xs sm:text-sm"><?php echo htmlspecialchars($success); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (isset($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 p-3 sm:p-4 rounded-lg mx-4 sm:mx-6 mb-3 sm:mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2 sm:mr-3"></i>
                        <span class="text-xs sm:text-sm"><?php echo htmlspecialchars($error); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Reset Password Form -->
            <form method="POST" action="?page=reset-password&token=<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>" class="px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8 pt-2">
                <div class="mb-4 sm:mb-5 relative">
                    <label for="password" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">New Password</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required
                           class="w-full pl-10 pr-10 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your new password">
                    <span class="absolute right-3 top-10 sm:top-11 text-gray-400 cursor-pointer" onclick="togglePassword('password', this)"><i class="fas fa-eye"></i></span>
                </div>

                <div class="mb-6 sm:mb-7 relative">
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Confirm New Password</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-check-double"></i></span>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="w-full pl-10 pr-10 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Confirm your new password">
                    <span class="absolute right-3 top-10 sm:top-11 text-gray-400 cursor-pointer" onclick="togglePassword('confirm_password', this)"><i class="fas fa-eye"></i></span>
                </div>

                <button type="submit" 
                        class="w-full bg-google-blue hover-bg-google-blue text-white font-semibold text-base sm:text-lg py-2 sm:py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-key"></i> Reset Password
                </button>
            </form>

            <!-- Links -->
            <div class="text-center pb-4 sm:pb-6">
                <p class="text-gray-600 text-xs sm:text-sm">
                    Remember your password? 
                    <a href="?page=login" class="text-google-blue hover:text-google-blue font-medium">
                        Sign in
                    </a>
                </p>
            </div>
            <div class="text-center pb-4 sm:pb-6">
                <a href="?page=home" class="text-gray-500 hover:text-gray-700 text-xs sm:text-sm transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>
    <script>
    function togglePassword(fieldId, el) {
        const input = document.getElementById(fieldId);
        const icon = el.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html> 