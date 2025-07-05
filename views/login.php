<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZapKard</title>
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
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 border border-gray-100">
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-google-blue to-google-green rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-credit-card text-white text-xl sm:text-2xl"></i>
                </div>
                <h1 class="text-xl sm:text-2xl font-medium mb-2">
                    <span style="color: #4285F4;">Z</span><span style="color: #EA4335;">a</span><span style="color: #FBBC05;">p</span><span style="color: #4285F4;">K</span><span style="color: #34A853;">a</span><span style="color: #EA4335;">r</span><span style="color: #4285F4;">d</span>
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">Welcome back! Please sign in to your account.</p>
                <p class="text-xs text-gray-500 mt-1">ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.</p>
            </div>

            <!-- Error Message -->
            <?php if (isset($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2 sm:mr-3"></i>
                        <span class="text-xs sm:text-sm"><?php echo htmlspecialchars($error); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="?page=login">
                <div class="mb-4 sm:mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your email">
                </div>

                <div class="mb-4 sm:mb-6 relative">
                    <label for="password" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full pr-10 px-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                           placeholder="Enter your password">
                    <span class="absolute right-3 top-10 sm:top-11 text-gray-400 cursor-pointer" onclick="togglePassword('password', this)"><i class="fas fa-eye"></i></span>
                </div>

                <div class="mb-4 sm:mb-6 text-right">
                    <a href="?page=forgot-password" class="text-google-blue hover:text-google-blue text-xs sm:text-sm font-medium">
                        Forgot your password?
                    </a>
                </div>

                <button type="submit" 
                        class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-2 sm:py-3 px-4 rounded-lg transition duration-200 shadow-sm hover:shadow-md text-sm sm:text-base">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>

            <!-- Links -->
            <div class="text-center mt-4 sm:mt-6">
                <p class="text-gray-600 text-xs sm:text-sm">
                    Don't have an account? 
                    <a href="?page=register" class="text-google-blue hover:text-google-blue font-medium">
                        Create account
                    </a>
                </p>
            </div>

            <div class="text-center mt-3 sm:mt-4">
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