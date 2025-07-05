<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Card - ZapKard</title>
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
        <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-google-blue to-google-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-credit-card text-white text-sm sm:text-lg"></i>
                        </div>
                        <a href="?page=dashboard" class="text-lg sm:text-2xl font-medium">
                            <span style="color: #4285F4 !important;">G</span><span style="color: #EA4335 !important;">o</span><span style="color: #FBBC05 !important;">o</span><span style="color: #4285F4 !important;">g</span><span style="color: #34A853 !important;">l</span><span style="color: #EA4335 !important;">e</span>
                            <span class="text-gray-900">Cards</span>
                        </a>
                    </div>
                    <a href="?page=dashboard" class="text-gray-600 hover:text-google-blue font-medium transition duration-200 text-sm sm:hidden">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="flex items-center justify-center sm:justify-end">
                    <a href="?page=dashboard" class="text-gray-600 hover:text-google-blue font-medium transition duration-200 text-sm sm:text-base hidden sm:inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-light text-gray-900 mb-3 sm:mb-4">Buy Virtual Card</h1>
                <p class="text-gray-600 text-sm sm:text-base">Purchase a new virtual card with your desired amount</p>
                <p class="text-xs sm:text-sm text-gray-500 mt-2">ZapKard works on Google Ads, Facebook Ads, and all online stores.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 lg:p-8 border border-gray-100">
                <!-- Account Balance -->
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base sm:text-lg font-medium text-gray-900">Account Balance</h3>
                            <p class="text-2xl sm:text-3xl font-medium text-google-blue">$<?php echo number_format($user['balance'], 2); ?></p>
                        </div>
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-blue rounded-full flex items-center justify-center">
                            <i class="fas fa-wallet text-white text-xl sm:text-2xl"></i>
                        </div>
                    </div>
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

                <!-- Success Message -->
                <?php if (isset($success)): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2 sm:mr-3"></i>
                            <span class="text-xs sm:text-sm"><?php echo htmlspecialchars($success); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Buy Card Form -->
                <div class="mb-4 sm:mb-6">
                    <label for="amount" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">
                        Card Amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="amount" name="amount" step="0.01" min="1" required
                               class="w-full pl-8 pr-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base"
                               placeholder="Enter amount (min: $1.00)">
                    </div>
                    <p class="text-xs sm:text-sm text-gray-500 mt-2">Enter the amount you want to load on your virtual card</p>
                </div>

                <div class="mb-4 sm:mb-6">
                    <label for="card_type" class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">
                        Card Type
                    </label>
                    <select id="card_type" name="card_type" required
                            class="w-full px-4 py-2 sm:py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-google-blue focus:border-transparent transition duration-200 text-sm sm:text-base">
                        <option value="">Select card type</option>
                        <option value="visa">Visa Virtual Card</option>
                        <option value="mastercard">Mastercard Virtual Card</option>
                    </select>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2 sm:mr-3"></i>
                        <div class="text-xs sm:text-sm text-blue-700">
                            <p class="font-medium mb-1">What you'll get:</p>
                            <ul class="space-y-1">
                                <li>• Virtual card number for online purchases</li>
                                <li>• Secure CVV and expiry date</li>
                                <li>• Instant activation</li>
                                <li>• Real-time balance tracking</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="openPaymentPopup()" 
                        class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-2 sm:py-3 px-4 rounded-lg transition duration-200 shadow-sm hover:shadow-md text-sm sm:text-base">
                    <i class="fas fa-credit-card mr-2"></i>Buy New Card
                </button>

                <!-- Quick Amount Buttons -->
                <div class="mt-4 sm:mt-6">
                    <p class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3">Quick amounts:</p>
                    <div class="grid grid-cols-3 sm:flex sm:flex-wrap gap-2">
                        <?php 
                        $quickAmounts = [10, 25, 50, 100, 200, 500];
                        foreach ($quickAmounts as $amount): 
                            if ($amount <= $user['balance']):
                        ?>
                            <button onclick="setAmount(<?php echo $amount; ?>)" 
                                    class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:border-google-blue hover:text-google-blue transition duration-200 text-xs sm:text-sm">
                                $<?php echo $amount; ?>
                            </button>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Popup Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-2 sm:p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-5/6 flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-3 sm:p-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-medium text-gray-900">Complete Payment</h3>
                <button onclick="closePaymentPopup()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="flex-1 p-0">
                <iframe id="paymentIframe" 
                        src="https://www.campay.net/pay/zapkard-2053-1751559836-CDB/" 
                        class="w-full h-full border-0 rounded-b-lg"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <script>
        function setAmount(amount) {
            document.getElementById('amount').value = amount;
        }

        function openPaymentPopup() {
            const amount = document.getElementById('amount').value;
            const cardType = document.getElementById('card_type').value;
            
            if (!amount || amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }
            
            if (!cardType) {
                alert('Please select a card type');
                return;
            }
            
            // Show the payment modal
            document.getElementById('paymentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Listen for messages from iframe (for payment completion)
            window.addEventListener('message', function(event) {
                if (event.origin === 'https://www.campay.net') {
                    // Handle payment completion
                    if (event.data.type === 'payment_completed') {
                        closePaymentPopup();
                        // You can add success handling here
                        alert('Payment completed successfully! Your card will be created shortly.');
                    }
                }
            });
        }

        function closePaymentPopup() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentPopup();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePaymentPopup();
            }
        });
    </script>
</body>
</html> 