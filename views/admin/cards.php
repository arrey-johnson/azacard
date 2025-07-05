<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards Management - ZapKard Admin</title>
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
        
        /* Enhanced card gradients and effects */
        .card-gradient-premium {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-gradient-standard {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .card-gradient-business {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .card-gradient-luxury {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .card-gradient-gold {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .card-gradient-silver {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Enhanced text shadows for better readability */
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        /* Glass morphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
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
                    <a href="?page=admin" class="text-gray-600 hover:text-google-blue font-medium transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <a href="?page=logout" class="bg-google-red hover-bg-google-red text-white px-4 py-2 rounded-lg transition duration-200 font-medium">
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
                <a href="?page=admin&action=users" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-users mr-2"></i>Users
                </a>
                <a href="?page=admin&action=cards" class="py-4 px-2 border-b-2 border-google-blue text-google-blue font-medium">
                    <i class="fas fa-credit-card mr-2"></i>Cards
                </a>
                <a href="?page=admin&action=transactions" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-history mr-2"></i>Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Cards</h1>
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 overflow-x-auto">
            <?php if (isset($_GET['success']) && $_GET['success'] === 'card_deleted'): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Card deleted successfully!
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error']) && $_GET['error'] === 'delete_failed'): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Failed to delete card. Please try again.
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-light text-gray-900">Cards Management</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" id="searchCards" placeholder="Search cards..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php if (empty($cards)): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-credit-card text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No Cards Found</h3>
                        <p class="text-gray-600">There are no virtual cards in the system yet.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $gradientClasses = ['card-gradient-premium', 'card-gradient-standard', 'card-gradient-business', 'card-gradient-luxury', 'card-gradient-gold', 'card-gradient-silver'];
                    $gradientIndex = 0;
                    foreach ($cards as $card): 
                        $gradientClass = $gradientClasses[$gradientIndex % count($gradientClasses)];
                        $gradientIndex++;
                    ?>
                        <div class="<?php echo $gradientClass; ?> rounded-xl p-6 text-white shadow-lg card-hover relative overflow-hidden">
                            <!-- Animated background overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                            
                            <!-- Card content -->
                            <div class="relative z-10">
                                <!-- Header with enhanced styling -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="glass-effect px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                        <i class="fas fa-credit-card mr-1"></i>Virtual Card
                                    </div>
                                    <div class="text-sm">
                                        <?php if ($card['is_active']): ?>
                                            <span class="glass-effect text-white px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        <?php else: ?>
                                            <span class="bg-red-500 bg-opacity-80 text-white px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                                <i class="fas fa-times-circle mr-1"></i>Inactive
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Card number with enhanced styling -->
                                <div class="text-lg font-bold mb-3 text-shadow tracking-wider">
                                    <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                                </div>
                                
                                <!-- Card details with better contrast -->
                                <div class="space-y-3 mb-4">
                                    <div class="flex justify-between items-center glass-effect px-3 py-2 rounded-lg">
                                        <span class="text-sm opacity-90 font-medium">CVV</span>
                                        <span class="font-bold text-shadow"><?php echo $card['cvv']; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center glass-effect px-3 py-2 rounded-lg">
                                        <span class="text-sm opacity-90 font-medium">Expires</span>
                                        <span class="font-bold text-shadow"><?php echo $card['expiry_date']; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center glass-effect px-3 py-2 rounded-lg">
                                        <span class="text-sm opacity-90 font-medium">Balance</span>
                                        <span class="font-bold text-shadow text-yellow-300">$<?php echo number_format($card['balance'], 2); ?></span>
                                    </div>
                                </div>

                                <!-- Owner and metadata with enhanced styling -->
                                <div class="border-t border-white border-opacity-30 pt-4 space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm opacity-90 font-medium">Owner</span>
                                        <span class="font-bold text-shadow text-blue-200"><?php echo htmlspecialchars($card['user_name']); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm opacity-90 font-medium">Created</span>
                                        <span class="font-medium text-shadow"><?php echo date('M j, Y', strtotime($card['created_at'])); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm opacity-90 font-medium">Card ID</span>
                                        <span class="font-bold text-shadow text-green-200">#<?php echo $card['id']; ?></span>
                                    </div>
                                </div>

                                <!-- Action buttons with enhanced styling -->
                                <div class="mt-4 pt-4 border-t border-white border-opacity-30 space-y-2">
                                    <a href="?page=admin&action=manage_user&id=<?php echo $card['user_id']; ?>" 
                                       class="block w-full glass-effect hover:bg-white hover:bg-opacity-30 text-white text-center text-sm font-medium py-2 px-3 rounded-lg transition duration-200 text-shadow">
                                        <i class="fas fa-user-edit mr-1"></i>Manage User
                                    </a>
                                    
                                    <form method="POST" action="?page=admin&action=delete_card_global" onsubmit="return confirm('Are you sure you want to delete this card? This action cannot be undone.');">
                                        <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $card['user_id']; ?>">
                                        <button type="submit" class="w-full bg-red-500 bg-opacity-80 hover:bg-red-600 text-white text-center text-sm font-medium py-2 px-3 rounded-lg transition duration-200 text-shadow">
                                            <i class="fas fa-trash mr-1"></i>Delete Card
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Cards Summary with enhanced styling -->
            <?php if (!empty($cards)): ?>
                <div class="mt-8 animated-gradient rounded-xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-4 text-shadow">Cards Summary</h3>
                    <div class="grid md:grid-cols-4 gap-6">
                        <div class="text-center glass-effect rounded-lg p-4">
                            <div class="text-2xl font-bold text-shadow"><?php echo count($cards); ?></div>
                            <div class="text-sm opacity-90">Total Cards</div>
                        </div>
                        <div class="text-center glass-effect rounded-lg p-4">
                            <div class="text-2xl font-bold text-shadow">
                                <?php echo count(array_filter($cards, function($card) { return $card['is_active']; })); ?>
                            </div>
                            <div class="text-sm opacity-90">Active Cards</div>
                        </div>
                        <div class="text-center glass-effect rounded-lg p-4">
                            <div class="text-2xl font-bold text-shadow">
                                <?php echo count(array_filter($cards, function($card) { return !$card['is_active']; })); ?>
                            </div>
                            <div class="text-sm opacity-90">Inactive Cards</div>
                        </div>
                        <div class="text-center glass-effect rounded-lg p-4">
                            <div class="text-2xl font-bold text-shadow text-yellow-300">
                                $<?php echo number_format(array_sum(array_column($cards, 'balance')), 2); ?>
                            </div>
                            <div class="text-sm opacity-90">Total Balance</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchCards').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.grid > div:not(.col-span-full)');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 