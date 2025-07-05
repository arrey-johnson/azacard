<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ZapKard</title>
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
        
        /* Mobile-specific styles */
        @media (max-width: 640px) {
            .mobile-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .mobile-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .mobile-card-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .mobile-stats-grid {
                grid-template-columns: 1fr;
            }
            .mobile-actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php if (!$user): ?>
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-medium text-gray-900 mb-2">User Not Found</h2>
                <p class="text-gray-600 mb-4">Your account could not be found. Please log in again.</p>
                <a href="?page=logout" class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Go to Login
                </a>
            </div>
        </div>
    <?php else: ?>
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
                <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-google-blue to-google-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-credit-card text-white text-sm sm:text-lg"></i>
                        </div>
                        <h1 class="text-lg sm:text-2xl font-medium">
                            <span style="color: #4285F4 !important;">Z</span><span style="color: #EA4335 !important;">a</span><span style="color: #FBBC05 !important;">p</span><span style="color: #4285F4 !important;">K</span><span style="color: #34A853 !important;">a</span><span style="color: #EA4335 !important;">r</span><span style="color: #4285F4 !important;">d</span>
                        </h1>
                    </div>
                    <a href="?page=logout" class="bg-google-red hover-bg-google-red text-white px-3 py-2 rounded-lg transition duration-200 font-medium text-sm sm:hidden">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="text-center sm:text-left">
                        <span class="text-gray-600 text-sm sm:text-base">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <div class="text-xs text-gray-500 mt-1 hidden sm:block">ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.</div>
                    </div>
                    <a href="?page=logout" class="bg-google-red hover-bg-google-red text-white px-4 py-2 rounded-lg transition duration-200 font-medium text-sm hidden sm:inline-flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Stats Cards -->
        <div class="grid mobile-stats-grid gap-3 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-google-blue rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                        <i class="fas fa-wallet text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-xs sm:text-sm">Account Balance</h3>
                        <p class="text-lg sm:text-2xl font-medium text-gray-900">$<?php echo number_format($user['balance'] ?? 0, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-google-green rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                        <i class="fas fa-credit-card text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-xs sm:text-sm">Total Cards</h3>
                        <p class="text-lg sm:text-2xl font-medium text-gray-900"><?php echo count($cards); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-google-yellow rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                        <i class="fas fa-exchange-alt text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-xs sm:text-sm">Total Transactions</h3>
                        <p class="text-lg sm:text-2xl font-medium text-gray-900"><?php echo count($transactions); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid mobile-actions-grid gap-3 sm:gap-6 mb-6 sm:mb-8">
            <button onclick="openPaymentPopup()" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group w-full">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-blue rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                    <i class="fas fa-plus-circle text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="text-gray-900 font-medium text-sm sm:text-base">Buy New Card</div>
                <div class="mt-2 text-xs text-gray-500">Card cost: <span class="font-semibold text-gray-700">$10</span> &mdash; <span class="font-semibold text-gray-700">$5</span> will be loaded onto your card.</div>
            </button>
            
            <button onclick="openLoadCardPopup()" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group w-full">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-green rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                    <i class="fas fa-upload text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="text-gray-900 font-medium text-sm sm:text-base">Load Card</div>
            </button>
            
            <a href="?page=check-balance" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group w-full">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-yellow rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                    <i class="fas fa-balance-scale text-white text-xl sm:text-2xl"></i>
                </div>
                <div class="text-gray-900 font-medium text-sm sm:text-base">Check Balance</div>
            </a>
        </div>

        <!-- Recent Cards -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6 sm:mb-8 border border-gray-100">
            <h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-credit-card mr-2 sm:mr-3 text-google-blue"></i>Your Cards
            </h2>
            
            <?php if (empty($cards)): ?>
                <div class="text-center py-6 sm:py-12">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-gray-400 text-2xl sm:text-3xl"></i>
                    </div>
                    <p class="text-gray-600 text-base sm:text-lg mb-4">No cards yet. Buy your first virtual card!</p>
                    <a href="#" onclick="openPaymentPopup(); return false;" class="inline-block bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition duration-200 text-sm sm:text-base">
                        Buy Card
                    </a>
                </div>
            <?php else: ?>
                <div class="grid mobile-card-grid gap-3 sm:gap-4">
                    <?php foreach (array_slice($cards, 0, 6) as $card): ?>
                        <div class="bg-gradient-to-br from-blue-900 via-blue-700 to-green-800 rounded-xl p-3 sm:p-4 text-gray-900 shadow-sm w-full">
                            <div class="flex justify-between items-start mb-3 sm:mb-4">
                                <div class="text-xs sm:text-sm opacity-75 text-gray-200">Virtual Card</div>
                                <div class="text-xs sm:text-sm">
                                    <?php if ($card['is_active']): ?>
                                        <span class="bg-white bg-opacity-20 text-white px-2 py-1 rounded-full text-xs">Active</span>
                                    <?php else: ?>
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-base sm:text-lg font-medium mb-2 text-white flex items-center space-x-2">
                                <span id="masked-card-number-<?php echo $card['id']; ?>" class="break-all">
                                    <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                                </span>
                                <span id="full-card-number-<?php echo $card['id']; ?>" style="display:none;" class="break-all">
                                    <?php echo $card['card_number']; ?>
                                </span>
                                <button type="button" onclick="toggleCardNumber(<?php echo $card['id']; ?>)" class="focus:outline-none ml-2 flex-shrink-0">
                                    <i id="eye-icon-<?php echo $card['id']; ?>" class="fas fa-eye"></i>
                                    <i id="eye-slash-icon-<?php echo $card['id']; ?>" class="fas fa-eye-slash" style="display:none;"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-3 gap-2 sm:gap-4 text-xs sm:text-sm">
                                <div class="flex flex-col">
                                        <div class="opacity-75 text-gray-200">CVV</div>
                                    <div class="flex items-center space-x-1">
                                        <span id="masked-cvv-<?php echo $card['id']; ?>" class="font-medium text-white">***</span>
                                        <span id="full-cvv-<?php echo $card['id']; ?>" class="font-medium text-white" style="display:none;">
                                            <?php echo htmlspecialchars($card['cvv']); ?>
                                        </span>
                                        <button type="button" onclick="toggleCVV(<?php echo $card['id']; ?>)" class="focus:outline-none">
                                            <i id="cvv-eye-icon-<?php echo $card['id']; ?>" class="fas fa-eye text-xs"></i>
                                            <i id="cvv-eye-slash-icon-<?php echo $card['id']; ?>" class="fas fa-eye-slash text-xs" style="display:none;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="opacity-75 text-gray-200">Expires</div>
                                    <div class="font-medium text-white"><?php echo $card['expiry_date']; ?></div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="opacity-75 text-gray-200">Balance</div>
                                    <div class="font-medium text-white">$<?php echo number_format($card['balance'], 2); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (count($cards) > 6): ?>
                    <div class="text-center mt-4 sm:mt-6">
                        <a href="?page=cards" class="text-google-blue hover:text-google-blue font-medium text-sm sm:text-base">
                            View all <?php echo count($cards); ?> cards
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100">
            <h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-history mr-2 sm:mr-3 text-google-blue"></i>Recent Transactions
            </h2>
            
            <?php if (empty($transactions)): ?>
                <div class="text-center py-6 sm:py-12">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-gray-400 text-2xl sm:text-3xl"></i>
                    </div>
                    <p class="text-gray-600 text-base sm:text-lg">No transactions yet.</p>
                </div>
            <?php else: ?>
                <!-- Mobile-friendly transaction cards -->
                <div class="space-y-3 sm:hidden">
                    <?php foreach (array_slice($transactions, 0, 5) as $transaction): ?>
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($transaction['description']); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo date('M j, Y H:i', strtotime($transaction['created_at'])); ?></div>
                                </div>
                                <div class="text-right ml-3">
                                    <div class="text-sm font-medium <?php echo $transaction['amount'] < 0 ? 'text-red-600' : 'text-green-600'; ?>">
                                        <?php echo ($transaction['amount'] < 0 ? '-' : '+') . '$' . number_format(abs($transaction['amount']), 2); ?>
                                    </div>
                                    <?php if ($transaction['type'] === 'card_purchase'): ?>
                                        <span class="bg-google-blue text-white px-2 py-1 rounded-full text-xs font-medium">Card Purchase</span>
                                    <?php elseif ($transaction['type'] === 'card_load'): ?>
                                        <span class="bg-google-green text-white px-2 py-1 rounded-full text-xs font-medium">Card Load</span>
                                    <?php else: ?>
                                        <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-medium"><?php echo ucfirst($transaction['type']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Desktop table view -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-gray-900">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 font-medium text-gray-700">Type</th>
                                <th class="text-left py-3 font-medium text-gray-700">Amount</th>
                                <th class="text-left py-3 font-medium text-gray-700">Description</th>
                                <th class="text-left py-3 font-medium text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="border-b border-gray-100">
                                    <td class="py-3">
                                        <?php if ($transaction['type'] === 'card_purchase'): ?>
                                            <span class="bg-google-blue text-white px-3 py-1 rounded-full text-xs font-medium">Card Purchase</span>
                                        <?php elseif ($transaction['type'] === 'card_load'): ?>
                                            <span class="bg-google-green text-white px-3 py-1 rounded-full text-xs font-medium">Card Load</span>
                                        <?php else: ?>
                                            <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-medium"><?php echo ucfirst($transaction['type']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3">
                                        <span class="<?php echo $transaction['amount'] < 0 ? 'text-red-600' : 'text-green-600'; ?> font-medium">
                                            <?php echo ($transaction['amount'] < 0 ? '-' : '+') . '$' . number_format(abs($transaction['amount']), 2); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-700"><?php echo htmlspecialchars($transaction['description']); ?></td>
                                    <td class="py-3 text-gray-600"><?php echo date('M j, Y H:i', strtotime($transaction['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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
                        src="https://www.campay.net/pay/google-cards-2053-1751639893-GEA/" 
                        class="w-full h-full border-0 rounded-b-lg"
                        frameborder="0"
                        allow="payment">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Load Card Payment Popup Modal -->
    <div id="loadCardModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-2 sm:p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-5/6 flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-3 sm:p-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-medium text-gray-900">Load Card Payment</h3>
                <button onclick="closeLoadCardPopup()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="flex-1 p-0">
                <iframe id="loadCardIframe" 
                        src="https://www.campay.net/pay/google-cards-2053-1751559869-WHF/" 
                        class="w-full h-full border-0 rounded-b-lg"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <script>
        function openPaymentPopup() {
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
                        // Optionally refresh the page to show updated data
                        window.location.reload();
                    }
                }
            });
        }

        function openLoadCardPopup() {
            // Show the load card payment modal
            document.getElementById('loadCardModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Listen for messages from iframe (for payment completion)
            window.addEventListener('message', function(event) {
                if (event.origin === 'https://www.campay.net') {
                    // Handle payment completion
                    if (event.data.type === 'payment_completed') {
                        closeLoadCardPopup();
                        // You can add success handling here
                        alert('Payment completed successfully! Your card will be loaded shortly.');
                        // Optionally refresh the page to show updated data
                        window.location.reload();
                    }
                }
            });
        }

        function closePaymentPopup() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function closeLoadCardPopup() {
            document.getElementById('loadCardModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentPopup();
            }
        });

        document.getElementById('loadCardModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoadCardPopup();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePaymentPopup();
                closeLoadCardPopup();
            }
        });

        function toggleCardNumber(cardId) {
            const masked = document.getElementById('masked-card-number-' + cardId);
            const full = document.getElementById('full-card-number-' + cardId);
            const eye = document.getElementById('eye-icon-' + cardId);
            const eyeSlash = document.getElementById('eye-slash-icon-' + cardId);
            if (masked.style.display === 'none') {
                masked.style.display = '';
                full.style.display = 'none';
                eye.style.display = '';
                eyeSlash.style.display = 'none';
            } else {
                masked.style.display = 'none';
                full.style.display = '';
                eye.style.display = 'none';
                eyeSlash.style.display = '';
            }
        }
        function toggleCVV(cardId) {
            const masked = document.getElementById('masked-cvv-' + cardId);
            const full = document.getElementById('full-cvv-' + cardId);
            const eye = document.getElementById('cvv-eye-icon-' + cardId);
            const eyeSlash = document.getElementById('cvv-eye-slash-icon-' + cardId);
            if (masked.style.display === 'none') {
                masked.style.display = '';
                full.style.display = 'none';
                eye.style.display = '';
                eyeSlash.style.display = 'none';
            } else {
                masked.style.display = 'none';
                full.style.display = '';
                eye.style.display = 'none';
                eyeSlash.style.display = '';
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
    <?php endif; ?>
</body>
</html> 