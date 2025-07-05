<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found - ZapKard</title>
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
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 border border-gray-100">
            <!-- 404 Icon -->
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-exclamation-triangle text-gray-400 text-2xl sm:text-4xl"></i>
            </div>
            
            <!-- Error Message -->
            <h1 class="text-4xl sm:text-6xl font-light text-gray-900 mb-3 sm:mb-4">404</h1>
            <h2 class="text-xl sm:text-2xl font-medium text-gray-900 mb-3 sm:mb-4">Page Not Found</h2>
            <p class="text-gray-600 mb-6 sm:mb-8 text-sm sm:text-base">The page you're looking for doesn't exist or has been moved.</p>
            
            <!-- Action Buttons -->
            <div class="space-y-3 sm:space-y-4">
                <a href="?page=home" class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition duration-200 shadow-sm hover:shadow-md block text-sm sm:text-base">
                    <i class="fas fa-home mr-2"></i>Go to Home
                </a>
                <a href="?page=dashboard" class="w-full border-2 border-gray-300 text-gray-700 hover:border-google-blue hover:text-google-blue font-medium py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition duration-200 block text-sm sm:text-base">
                    <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                </a>
            </div>
            
            <!-- Help Text -->
            <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                <p class="text-xs sm:text-sm text-gray-500">
                    If you believe this is an error, please contact support.
                    <br>ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.
                </p>
            </div>
        </div>
    </div>
</body>
</html> 