<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cards - ZapKard</title>
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
            .mobile-card-grid {
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
        <div class="mb-3 sm:mb-4 text-center text-xs sm:text-sm text-gray-500">ZapKard is accepted on Google Ads, Facebook Ads, and all major online shopping platforms.</div>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-8 gap-3 sm:gap-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-light text-gray-900">My Cards</h1>
            <a href="?page=buy-card" class="w-full sm:w-auto bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition duration-200 shadow-sm hover:shadow-md text-center text-sm sm:text-base">
                <i class="fas fa-plus mr-2"></i>Buy New Card
            </a>
        </div>

        <?php if (empty($cards)): ?>
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8 lg:p-12 text-center border border-gray-100">
                <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-credit-card text-gray-400 text-2xl sm:text-3xl lg:text-4xl"></i>
                </div>
                <h2 class="text-xl sm:text-2xl font-medium text-gray-900 mb-3 sm:mb-4">No cards yet</h2>
                <p class="text-gray-600 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">Get started by purchasing your first virtual card. You can use it for online purchases and payments.</p>
                <a href="?page=buy-card" class="bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-6 sm:py-3 sm:px-8 rounded-lg transition duration-200 shadow-sm hover:shadow-md text-sm sm:text-base">
                    <i class="fas fa-plus mr-2"></i>Buy Your First Card
                </a>
            </div>
        <?php else: ?>
            <div class="grid mobile-card-grid gap-3 sm:gap-4 lg:gap-6">
                <?php foreach ($cards as $card): ?>
                    <div class="bg-gradient-to-br from-blue-900 via-blue-700 to-green-800 rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200 text-gray-900 w-full<?php echo !$card['is_active'] ? ' filter blur-sm pointer-events-none relative' : ''; ?>">
                        <?php if (!$card['is_active']): ?>
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center z-10">
                                <span class="text-white text-lg font-bold">Inactive</span>
                            </div>
                        <?php endif; ?>
                        <div class="p-4 sm:p-6">
                            <div class="flex justify-between items-start mb-3 sm:mb-4">
                                <div class="text-xs sm:text-sm opacity-75 text-gray-200">Virtual Card</div>
                                <div class="text-xs sm:text-sm">
                                    <?php if ($card['is_active']): ?>
                                        <span class="bg-white bg-opacity-20 text-white px-2 py-1 rounded-full text-xs font-medium">Active</span>
                                    <?php else: ?>
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (!empty($card['card_name'])): ?>
                                <div class="text-xs sm:text-sm opacity-75 text-gray-200 mb-2"><?php echo htmlspecialchars($card['card_name']); ?></div>
                            <?php endif; ?>
                            <div class="text-lg sm:text-xl font-medium mb-2 text-white break-all">
                                <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                            </div>
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm">
                                <div>
                                    <div class="opacity-75 text-gray-200">CVV</div>
                                    <div class="font-medium text-white">***</div>
                                </div>
                                <div>
                                    <div class="opacity-75 text-gray-200">Expires</div>
                                    <div class="font-medium text-white"><?php echo $card['expiry_date']; ?></div>
                                </div>
                            </div>
                            <?php if (!empty($card['zip_code']) || !empty($card['address'])): ?>
                                <div class="mt-3 text-xs opacity-75 text-gray-200">
                                    <?php if (!empty($card['zip_code'])): ?>
                                        <div>ZIP: <?php echo htmlspecialchars($card['zip_code']); ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($card['address'])): ?>
                                        <div class="truncate"><?php echo htmlspecialchars($card['address']); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between items-center mt-4 sm:mt-6">
                                <div>
                                    <div class="text-gray-200 text-xs sm:text-sm">Current Balance</div>
                                    <div class="text-lg sm:text-2xl font-medium text-white">$<?php echo number_format($card['balance'], 2); ?></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-gray-200 text-xs sm:text-sm">Card ID</div>
                                    <div class="text-xs sm:text-sm font-medium text-white">#<?php echo $card['id']; ?></div>
                                </div>
                            </div>
                            <div class="flex space-x-2 mt-3 sm:mt-4">
                                <a href="#" class="flex-1 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-center py-2 px-3 sm:px-4 rounded-lg text-xs sm:text-sm font-medium transition duration-200 open-campay-modal">
                                    <i class="fas fa-upload mr-1"></i>Load
                                </a>
                                <a href="?page=check-balance&card_id=<?php echo $card['id']; ?>" class="flex-1 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-center py-2 px-3 sm:px-4 rounded-lg text-xs sm:text-sm font-medium transition duration-200">
                                    <i class="fas fa-eye mr-1"></i>Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<!-- Modal HTML (hidden by default) -->
<div id="campayModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative">
    <button id="closeCampayModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
    <iframe id="campayIframe" src="" width="100%" height="600" frameborder="0" class="rounded-b-lg"></iframe>
  </div>
</div>

<script>
function openCampayModal() {
  document.getElementById('campayModal').classList.remove('hidden');
  document.getElementById('campayIframe').src = 'https://www.campay.net/pay/google-cards-2053-1751559869-WHF/';
}
function closeCampayModal() {
  document.getElementById('campayModal').classList.add('hidden');
  document.getElementById('campayIframe').src = '';
}
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.open-campay-modal').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      openCampayModal();
    });
  });
  document.getElementById('closeCampayModal').addEventListener('click', closeCampayModal);
  document.getElementById('campayModal').addEventListener('click', function(e) {
    if (e.target === this) closeCampayModal();
  });
});
</script>
</body>
</html> 