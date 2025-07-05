<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZapKard</title>
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
                    <span style="color: #4285F4;">Z</span><span style="color: #EA4335;">a</span><span style="color: #FBBC05;">p</span><span style="color: #4285F4;">K</span><span style="color: #34A853;">a</span><span style="color: #EA4335;">r</span><span style="color: #4285F4;">d</span>
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">Create your account to get started</p>
                <p class="text-xs text-gray-500 mt-1">ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.</p>
            </div>

            <!-- Error Message -->
            <?php if (isset($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 p-3 sm:p-4 rounded-lg mx-4 sm:mx-6 mb-3 sm:mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2 sm:mr-3"></i>
                        <span class="text-xs sm:text-sm"><?php echo htmlspecialchars($error); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="POST" action="?page=register" class="px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8 pt-2">
                <div class="mb-4 sm:mb-5 relative">
                    <label for="name" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Full Name</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-user"></i></span>
                    <input type="text" id="name" name="name" required
                           class="w-full pl-10 pr-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your full name">
                </div>

                <div class="mb-4 sm:mb-5 relative">
                    <label for="username" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Username</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-at"></i></span>
                    <input type="text" id="username" name="username" required pattern="[a-zA-Z0-9_]{3,20}"
                           class="w-full pl-10 pr-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Choose a username (3-20 characters)">
                    <div class="text-xs text-gray-500 mt-1">Only letters, numbers, and underscores allowed</div>
                </div>

                <div class="mb-4 sm:mb-5 relative">
                    <label for="email" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Email Address</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required
                           class="w-full pl-10 pr-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your email">
                </div>

                <div class="mb-4 sm:mb-5 relative">
                    <label for="phone" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Phone Number</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-phone"></i></span>
                    <input type="tel" id="phone" name="phone" required pattern="[0-9\-\+\s\(\)]{7,}" 
                           class="w-full pl-10 pr-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your phone number">
                </div>

                <div class="mb-4 sm:mb-5 relative">
                    <label for="password" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Password</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required
                           class="w-full pl-10 pr-10 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Create a password">
                    <span class="absolute right-3 top-10 sm:top-11 text-gray-400 cursor-pointer" onclick="togglePassword('password', this)"><i class="fas fa-eye"></i></span>
                </div>

                <div class="mb-6 sm:mb-7 relative">
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Confirm Password</label>
                    <span class="absolute left-3 top-10 sm:top-11 text-gray-400"><i class="fas fa-check-double"></i></span>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="w-full pl-10 pr-10 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Confirm your password">
                    <span class="absolute right-3 top-10 sm:top-11 text-gray-400 cursor-pointer" onclick="togglePassword('confirm_password', this)"><i class="fas fa-eye"></i></span>
                </div>

                <button type="submit" 
                        class="w-full bg-google-blue hover-bg-google-blue text-white font-semibold text-base sm:text-lg py-2 sm:py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
                <div class="flex items-center justify-center mt-3 sm:mt-4">
                    <i class="fas fa-lock text-google-blue mr-2"></i>
                    <span class="text-xs text-gray-500">Your information is securely encrypted</span>
                </div>
            </form>
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

            <!-- Links -->
            <div class="text-center pb-4 sm:pb-6">
                <p class="text-gray-600 text-xs sm:text-sm">
                    Already have an account? 
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
    <!-- Smartsupp Live Chat script -->
    <script type="text/javascript">
    var _smartsupp = _smartsupp || {};
    _smartsupp.key = '6f45c5f4f4b26bd7e76b24f6b54a4d6bedcbbefc';
    window.smartsupp||(function(d) {
      var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
      s=d.getElementsByTagName('script')[0];c=d.createElement('script');
      c.type='text/javascript';c.charset='utf-8';c.async=true;
      c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
    })(document);
    </script>
    <noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>
</body>
</html> 