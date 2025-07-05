<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Balance - ZapKard</title>
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
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-light text-gray-900 mb-3 sm:mb-4">Check Balance</h1>
                <p class="text-gray-600 text-sm sm:text-base">View your account and card balances</p>
                <p class="text-xs text-gray-500 mt-1">ZapKard: Pay on Google Ads, Facebook Ads, and all online stores.</p>
            </div>

            <!-- Account Balance -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-gray-100">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-lg sm:text-xl font-medium text-gray-900">Account Overview</h2>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-google-blue rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-white text-lg sm:text-xl"></i>
                    </div>
                </div>
                
                <div class="grid mobile-stats-grid gap-4 sm:gap-6">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-medium text-google-blue mb-1 sm:mb-2">$<?php echo number_format($user['balance'], 2); ?></div>
                        <div class="text-gray-600 text-xs sm:text-sm">Available Balance</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-medium text-google-green mb-1 sm:mb-2"><?php echo count($cards); ?></div>
                        <div class="text-gray-600 text-xs sm:text-sm">Total Cards</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-medium text-google-yellow mb-1 sm:mb-2">$<?php echo number_format(array_sum(array_column($cards, 'balance')), 2); ?></div>
                        <div class="text-gray-600 text-xs sm:text-sm">Total Card Balance</div>
                    </div>
                </div>
            </div>

            <!-- Card Balances -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 lg:p-8 border border-gray-100">
                <h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-4 sm:mb-6 flex items-center">
                    <i class="fas fa-credit-card mr-2 sm:mr-3 text-google-blue"></i>Your Cards
                </h2>
                
                <?php if (empty($cards)): ?>
                    <div class="text-center py-6 sm:py-12">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-credit-card text-gray-400 text-2xl sm:text-3xl"></i>
                        </div>
                        <p class="text-gray-600 text-base sm:text-lg mb-4">No cards yet. Buy your first virtual card!</p>
                        <a href="?page=buy-card" class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition duration-200 text-sm sm:text-base">
                    Buy Card
                </a>
                    </div>
                <?php else: ?>
                    <div class="grid mobile-card-grid gap-4 sm:gap-6">
                        <?php foreach ($cards as $card): ?>
                            <div class="bg-gradient-to-r from-google-blue to-google-green rounded-xl p-4 sm:p-6 text-white shadow-sm">
                                <div class="flex justify-between items-start mb-3 sm:mb-4">
                                    <div class="text-xs sm:text-sm opacity-75">Virtual Card</div>
                                    <div class="text-xs sm:text-sm">
                                        <?php if ($card['is_active']): ?>
                                            <span class="bg-white bg-opacity-20 text-white px-2 py-1 rounded-full text-xs font-medium">Active</span>
                                        <?php else: ?>
                                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if (!empty($card['card_name'])): ?>
                                    <div class="text-xs sm:text-sm opacity-75 mb-2"><?php echo htmlspecialchars($card['card_name']); ?></div>
                                <?php endif; ?>
                                
                                <div class="text-base sm:text-lg font-medium mb-2 break-all">
                                    <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm mb-3 sm:mb-4">
                                    <div>
                                        <div class="opacity-75">CVV</div>
                                        <div class="font-medium">***</div>
                                    </div>
                                    <div>
                                        <div class="opacity-75">Expires</div>
                                        <div class="font-medium"><?php echo $card['expiry_date']; ?></div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($card['zip_code']) || !empty($card['address'])): ?>
                                    <div class="text-xs opacity-75 mb-3">
                                        <?php if (!empty($card['zip_code'])): ?>
                                            <div>ZIP: <?php echo htmlspecialchars($card['zip_code']); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($card['address'])): ?>
                                            <div class="truncate"><?php echo htmlspecialchars($card['address']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="border-t border-white border-opacity-20 pt-3 sm:pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="opacity-75 text-xs sm:text-sm">Balance</span>
                                        <span class="font-medium text-lg sm:text-xl">$<?php echo number_format($card['balance'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="grid mobile-actions-grid gap-4 sm:gap-6 mt-6 sm:mt-8">
                <a href="?page=buy-card" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-blue rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                        <i class="fas fa-plus-circle text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-gray-900 font-medium text-sm sm:text-base">Buy New Card</div>
                </a>
                
                <a href="?page=load-card" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-green rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                        <i class="fas fa-upload text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-gray-900 font-medium text-sm sm:text-base">Load Card</div>
                </a>
                
                <a href="?page=cards" class="bg-white hover:shadow-md rounded-xl p-4 sm:p-6 border border-gray-100 transition duration-200 text-center group">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-google-yellow rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition duration-200">
                        <i class="fas fa-list text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-gray-900 font-medium text-sm sm:text-base">View All Cards</div>
                </a>
            </div>
        </div>
          </div>
  </body>
</html> 