<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'ZapKard - Virtual Cards for Online Payments'; ?></title>
    <meta name="description" content="<?php echo $metaDescription ?? 'Buy, manage, and use virtual cards for Google Ads, Facebook Ads, and more.'; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://zapkard.shop/">
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $ogTitle ?? ($pageTitle ?? 'ZapKard - Virtual Cards for Online Payments'); ?>">
    <meta property="og:description" content="<?php echo $ogDescription ?? ($metaDescription ?? 'Buy, manage, and use virtual cards for Google Ads, Facebook Ads, and more.'); ?>">
    <meta property="og:url" content="https://zapkard.shop/">
    <meta property="og:image" content="https://zapkard.shop/assets/og-image.png">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $ogTitle ?? ($pageTitle ?? 'ZapKard - Virtual Cards for Online Payments'); ?>">
    <meta name="twitter:description" content="<?php echo $ogDescription ?? ($metaDescription ?? 'Buy, manage, and use virtual cards for Google Ads, Facebook Ads, and more.'); ?>">
    <meta name="twitter:image" content="https://zapkard.shop/assets/og-image.png">
    <!-- JSON-LD Schema.org -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "ZapKard",
      "url": "https://zapkard.shop",
      "logo": "https://zapkard.shop/assets/logo.png",
      "sameAs": [
        "https://facebook.com/zapkard",
        "https://twitter.com/zapkard"
      ]
    }
    </script>
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
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-google-blue to-google-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-white text-sm sm:text-lg"></i>
                    </div>
                    <h1 class="text-lg sm:text-2xl font-medium">
                        <span style="color: #4285F4 !important;">Z</span><span style="color: #EA4335 !important;">a</span><span style="color: #FBBC05 !important;">p</span><span style="color: #4285F4 !important;">K</span><span style="color: #34A853 !important;">a</span><span style="color: #EA4335 !important;">r</span><span style="color: #4285F4 !important;">d</span>
                        <span class="text-gray-900"> </span>
                    </h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="?page=login" class="text-gray-600 hover:text-google-blue font-medium transition duration-200 text-sm sm:text-base">
                        Sign in
                    </a>
                    <a href="?page=register" class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 sm:px-6 rounded-lg transition duration-200 text-sm sm:text-base">
                        Get started
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-3 sm:px-4 py-8 sm:py-12">
        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto mb-12 sm:mb-16 flex flex-col lg:flex-row items-center justify-center gap-8 sm:gap-10 lg:gap-16 px-2 sm:px-0">
            <div class="flex-shrink-0 flex justify-center lg:justify-start w-full lg:w-auto mb-6 lg:mb-0">
                <svg width="300" height="180" viewBox="0 0 370 220" fill="none" xmlns="http://www.w3.org/2000/svg" class="shadow-xl rounded-2xl w-full max-w-xs lg:max-w-none">
                    <defs>
                        <radialGradient id="cardBg" cx="50%" cy="40%" r="90%" fx="50%" fy="30%">
                            <stop offset="0%" stop-color="#fff" stop-opacity="0.95"/>
                            <stop offset="100%" stop-color="#e3eafc" stop-opacity="1"/>
                        </radialGradient>
                        <linearGradient id="googleWave" x1="0" y1="200" x2="370" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#4285F4"/>
                            <stop offset="0.25" stop-color="#EA4335"/>
                            <stop offset="0.5" stop-color="#FBBC05"/>
                            <stop offset="0.75" stop-color="#34A853"/>
                            <stop offset="1" stop-color="#4285F4"/>
                        </linearGradient>
                    </defs>
                    <!-- Card background -->
                    <rect x="0" y="0" width="370" height="220" rx="28" fill="url(#cardBg)"/>
                    <!-- Google color wave accent -->
                    <path d="M0 180 Q 90 200 185 180 T 370 180 L 370 220 L 0 220 Z" fill="url(#googleWave)" fill-opacity="0.85"/>
                    <!-- Chip -->
                    <g>
                        <rect x="38" y="54" width="38" height="28" rx="7" fill="#E0E0E0" stroke="#BDBDBD" stroke-width="2"/>
                        <rect x="44" y="60" width="26" height="4" rx="2" fill="#BDBDBD"/>
                        <rect x="44" y="68" width="26" height="4" rx="2" fill="#BDBDBD"/>
                        <rect x="44" y="76" width="26" height="4" rx="2" fill="#BDBDBD"/>
                        <rect x="50" y="54" width="2" height="28" rx="1" fill="#BDBDBD" fill-opacity="0.5"/>
                    </g>
                    <!-- Contactless icon -->
                    <g opacity="0.7">
                        <path d="M90 65 Q95 70 90 75" stroke="#888" stroke-width="2" fill="none"/>
                        <path d="M95 62 Q102 70 95 78" stroke="#888" stroke-width="2" fill="none"/>
                    </g>
                    <!-- ZapKard Logo on Card -->
                    <g font-family="Roboto, Arial, sans-serif" font-weight="700">
                        <text x="110" y="80" font-size="28">
                            <tspan fill="#4285F4">Z</tspan><tspan fill="#EA4335">a</tspan><tspan fill="#FBBC05">p</tspan><tspan fill="#4285F4">K</tspan><tspan fill="#34A853">a</tspan><tspan fill="#EA4335">r</tspan><tspan fill="#4285F4">d</tspan>
                        </text>
                    </g>
                    <!-- Card Number -->
                    <text x="38" y="145" font-family="Roboto Mono, monospace" font-size="22" fill="#222" letter-spacing="4">1234  5678  9012  3456</text>
                    <!-- Expiry and Name -->
                    <text x="38" y="170" font-family="Roboto, Arial, sans-serif" font-size="13" fill="#555">EXP</text>
                    <text x="110" y="170" font-family="Roboto, Arial, sans-serif" font-size="13" fill="#222">12/29</text>
                    <text x="38" y="192" font-family="Roboto, Arial, sans-serif" font-size="15" fill="#222" font-weight="700">EMPEROR JOHNSON</text>
                    <!-- Virtual Card Label -->
                    <text x="270" y="65" font-family="Roboto, Arial, sans-serif" font-size="13" fill="#4285F4" font-weight="700">VIRTUAL CARD</text>
                </svg>
            </div>
            <div class="flex-1 text-center lg:text-left">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-light text-gray-900 mb-4 sm:mb-6 leading-tight">
                    Your Digital Financial
                    <span class="text-google-blue font-medium">Freedom</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-600 mb-6 sm:mb-8 max-w-2xl">
                    ZapKard is your official virtual card solution for online payments. Pay anywhere online—including Google Ads, Facebook Ads, and all major e-commerce platforms. Experience the future of digital payments with our secure virtual card system. Create cards instantly, load funds, and manage your finances with ease.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3 sm:gap-4">
                    <a href="?page=register" class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 sm:py-3 px-6 sm:px-8 rounded-lg transition duration-200 shadow-md hover:shadow-lg text-sm sm:text-base">
                        <i class="fas fa-user-plus mr-2"></i>Get Started
                    </a>
                    <a href="?page=login" class="border-2 border-gray-300 text-gray-700 hover:border-google-blue hover:text-google-blue font-medium py-2 sm:py-3 px-6 sm:px-8 rounded-lg transition duration-200 text-sm sm:text-base">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </a>
                </div>
            </div>
        </div>

        <!-- Features (Improved) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 sm:gap-8 max-w-6xl mx-auto mb-12 sm:mb-16">
            <div class="bg-white rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-md transition duration-200 border border-gray-100">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-blue rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-bolt text-white text-xl sm:text-2xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Instant Virtual Cards</h3>
                <p class="text-gray-600 text-sm sm:text-base">Create and activate your Google-branded virtual cards in seconds. No paperwork, no waiting.</p>
            </div>
            <div class="bg-white rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-md transition duration-200 border border-gray-100">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-green rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-shield-alt text-white text-xl sm:text-2xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Bank-Level Security</h3>
                <p class="text-gray-600 text-sm sm:text-base">Your funds and data are protected with advanced encryption and real-time fraud monitoring.</p>
            </div>
            <div class="bg-white rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-md transition duration-200 border border-gray-100">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-yellow rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-globe text-white text-xl sm:text-2xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Global Acceptance</h3>
                <p class="text-gray-600 text-sm sm:text-base">Use your card anywhere online—Google Ads, Facebook Ads, Amazon, and all major e-commerce platforms.</p>
            </div>
            <div class="bg-white rounded-xl p-6 sm:p-8 text-center shadow-sm hover:shadow-md transition duration-200 border border-gray-100">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-red rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-mobile-alt text-white text-xl sm:text-2xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Effortless Management</h3>
                <p class="text-gray-600 text-sm sm:text-base">Load funds, check balances, and manage cards from any device, anytime.</p>
            </div>
        </div>

        <!-- Why Choose Us (New Section) -->
        <div class="max-w-5xl mx-auto mb-12 sm:mb-16">
            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 text-center mb-8 sm:mb-12">Why Choose ZapKard?</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
                <div class="flex flex-col items-center text-center bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <i class="fas fa-users text-google-blue text-2xl mb-3"></i>
                    <div class="font-semibold text-gray-900 mb-1">10,000+ Users</div>
                    <div class="text-gray-600 text-sm">Trusted by thousands of businesses and individuals worldwide.</div>
                </div>
                <div class="flex flex-col items-center text-center bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <i class="fas fa-headset text-google-green text-2xl mb-3"></i>
                    <div class="font-semibold text-gray-900 mb-1">24/7 Support</div>
                    <div class="text-gray-600 text-sm">Get help anytime from our expert support team.</div>
                </div>
                <div class="flex flex-col items-center text-center bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <i class="fas fa-percent text-google-yellow text-2xl mb-3"></i>
                    <div class="font-semibold text-gray-900 mb-1">No Hidden Fees</div>
                    <div class="text-gray-600 text-sm">Transparent pricing—what you see is what you pay.</div>
                </div>
                <div class="flex flex-col items-center text-center bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <i class="fas fa-rocket text-google-red text-2xl mb-3"></i>
                    <div class="font-semibold text-gray-900 mb-1">Fast Approvals</div>
                    <div class="text-gray-600 text-sm">Get your card and start spending in minutes, not days.</div>
                </div>
            </div>
        </div>

        <!-- How it works (Improved) -->
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 text-center mb-8 sm:mb-12">How It Works</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-8">
                <div class="text-center relative">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-blue text-white rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 font-bold text-lg sm:text-xl">1</div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3">Register Account</h4>
                    <p class="text-gray-600 text-sm sm:text-base">Sign up for free in seconds.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-green text-white rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 font-bold text-lg sm:text-xl">2</div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3">Buy Virtual Card</h4>
                    <p class="text-gray-600 text-sm sm:text-base">Choose your amount and get your card instantly.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-yellow text-white rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 font-bold text-lg sm:text-xl">3</div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3">Start Using</h4>
                    <p class="text-gray-600 text-sm sm:text-base">Pay for ads, shop online, and manage your spending.</p>
                </div>
            </div>
            <div class="text-center">
                <a href="?page=register" class="inline-block bg-google-blue hover-bg-google-blue text-white font-medium py-2 sm:py-3 px-8 sm:px-12 rounded-lg transition duration-200 shadow-md hover:shadow-lg text-base sm:text-lg">
                    Get Your Card Now
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-4xl mx-auto mb-12 sm:mb-16">
            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 text-center mb-8 sm:mb-12">Frequently Asked Questions</h3>
            <div class="space-y-6">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="font-semibold text-gray-900 mb-2">How fast can I get my virtual card?</div>
                    <div class="text-gray-600 text-sm">You can get your ZapKard instantly after registration and payment. No paperwork or waiting required.</div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="font-semibold text-gray-900 mb-2">Where can I use my ZapKard?</div>
                    <div class="text-gray-600 text-sm">Your card works on Google Ads, Facebook Ads, Amazon, and all major online stores worldwide.</div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="font-semibold text-gray-900 mb-2">Is my money safe?</div>
                    <div class="text-gray-600 text-sm">Absolutely. We use bank-level encryption and real-time fraud monitoring to keep your funds and data secure.</div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="font-semibold text-gray-900 mb-2">How do I contact support?</div>
                    <div class="text-gray-600 text-sm">You can reach our 24/7 support team via live chat or email. We’re always here to help!</div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="max-w-2xl mx-auto mb-16">
            <h3 class="text-2xl sm:text-3xl font-light text-gray-900 text-center mb-8 sm:mb-12">Contact Us</h3>
            <form class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-5" method="POST" action="#">
                <?php if (!empty($contactSuccess)): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-center">
                        <i class="fas fa-check-circle mr-2"></i><?php echo $contactSuccess; ?>
                    </div>
                <?php elseif (!empty($contactError)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-center">
                        <i class="fas fa-exclamation-circle mr-2"></i><?php echo $contactError; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <label for="contact-name" class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" id="contact-name" name="name" required class="w-full px-4 py-2 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm" placeholder="Your Name">
                </div>
                <div>
                    <label for="contact-email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" id="contact-email" name="email" required class="w-full px-4 py-2 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm" placeholder="you@email.com">
                </div>
                <div>
                    <label for="contact-message" class="block text-gray-700 font-medium mb-1">Message</label>
                    <textarea id="contact-message" name="message" rows="4" required class="w-full px-4 py-2 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm" placeholder="How can we help you?"></textarea>
                </div>
                <button type="submit" class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg text-base">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 text-center py-6 sm:py-8 mt-12 sm:mt-16">
        <div class="container mx-auto px-3 sm:px-4">
            <p class="text-gray-600 text-sm sm:text-base">&copy; 2024 ZapKard. All rights reserved.</p>
        </div>
    </footer>
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