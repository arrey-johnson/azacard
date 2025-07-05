<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User - ZapKard Admin</title>
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
                <a href="?page=admin&action=cards" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-credit-card mr-2"></i>Cards
                </a>
                <a href="?page=admin&action=transactions" class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-history mr-2"></i>Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Manage User</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'transaction_recorded'): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Transaction recorded successfully!
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!$user): ?>
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-medium text-gray-900 mb-2">User Not Found</h2>
                <p class="text-gray-600">The user you're looking for doesn't exist.</p>
                <a href="?page=admin&action=users" class="inline-block mt-4 bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Back to Users
                </a>
            </div>
        <?php else: ?>
            <!-- User Info -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6 mb-6 overflow-x-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-medium text-gray-900">Manage User: <?php echo htmlspecialchars($user['name']); ?></h2>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">User ID: <?php echo $user['id']; ?></p>
                        <p class="text-sm text-gray-500">Joined: <?php echo date('M j, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">User Details</h3>
                        <p class="text-sm text-gray-600"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p class="text-sm text-gray-600"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="text-sm text-gray-600"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Account Balance</h3>
                        <p class="text-2xl font-bold text-google-blue">$<?php echo number_format($user['balance'], 2); ?></p>
                        <p class="text-sm text-gray-500">Current balance</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Cards</h3>
                        <p class="text-2xl font-bold text-google-green"><?php echo count($userCards); ?></p>
                        <p class="text-sm text-gray-500">Total cards</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Manage Account Balance -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-wallet mr-3 text-google-blue"></i>Manage Account Balance
                    </h3>
                    
                    <form method="POST" action="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>">
                        <input type="hidden" name="action" value="update_balance">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Action</label>
                            <select name="balance_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                                <option value="add">Add Balance</option>
                                <option value="subtract">Subtract Balance</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Amount ($)</label>
                            <input type="number" name="amount" step="0.01" min="0.01" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                   placeholder="Enter amount">
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Description</label>
                            <input type="text" name="description" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                   placeholder="Reason for balance adjustment">
                        </div>
                        
                        <button type="submit" class="w-full bg-google-blue hover-bg-google-blue text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-save mr-2"></i>Update Balance
                        </button>
                    </form>
                </div>

                <!-- Create New Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-plus-circle mr-3 text-google-green"></i>Create New Card
                    </h3>
                    
                    <form method="POST" action="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>">
                        <input type="hidden" name="action" value="create_card">
                        
                        <!-- Card Type and Balance -->
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Card Type</label>
                                <select name="card_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                                    <option value="visa">Visa Virtual Card</option>
                                    <option value="mastercard">Mastercard Virtual Card</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Initial Balance ($)</label>
                                <input type="number" name="card_amount" step="0.01" min="0.01" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Enter initial balance">
                            </div>
                        </div>

                        <!-- Manual Card Details -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Card Details</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Card Number</label>
                                    <input type="text" name="card_number" maxlength="16" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="1234567890123456">
                                    <p class="text-sm text-gray-500 mt-1">Leave empty for auto-generation</p>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">CVV</label>
                                    <input type="text" name="cvv" maxlength="3" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="123">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" maxlength="5" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="MM/YY">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Card Name</label>
                                    <input type="text" name="card_name" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="Card holder name">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Zip Code</label>
                                    <input type="text" name="zip_code" maxlength="10" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                           placeholder="12345">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-medium mb-2">Billing Address</label>
                                    <textarea name="address" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                              placeholder="Enter billing address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-google-green hover-bg-google-green text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-credit-card mr-2"></i>Create Card
                        </button>
                    </form>
                </div>

                <script>
                // Auto-format card number input
                document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 16) value = value.substr(0, 16);
                    e.target.value = value;
                });

                // Auto-format CVV input
                document.querySelector('input[name="cvv"]').addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 3) value = value.substr(0, 3);
                    e.target.value = value;
                });

                // Auto-format expiry date input
                document.querySelector('input[name="expiry_date"]').addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substr(0, 2) + '/' + value.substr(2);
                    }
                    if (value.length > 5) value = value.substr(0, 5);
                    e.target.value = value;
                });

                // Auto-format zip code input
                document.querySelector('input[name="zip_code"]').addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 10) value = value.substr(0, 10);
                    e.target.value = value;
                });
                </script>
            </div>

            <!-- User Cards -->
            <div class="bg-white rounded-xl shadow-lg p-6 mt-8 border border-gray-100">
                <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-credit-card mr-3 text-google-green"></i>User Cards
                </h3>
                
                <?php if (empty($userCards)): ?>
                    <p class="text-gray-500 text-center py-8">This user has no cards yet.</p>
                <?php else: ?>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php 
                        $gradientClasses = ['card-gradient-premium', 'card-gradient-standard', 'card-gradient-business', 'card-gradient-luxury', 'card-gradient-gold', 'card-gradient-silver'];
                        $gradientIndex = 0;
                        foreach ($userCards as $card): 
                            $gradientClass = $gradientClasses[$gradientIndex % count($gradientClasses)];
                            $gradientIndex++;
                        ?>
                            <div class="<?php echo $gradientClass; ?> rounded-xl p-6 text-white shadow-lg card-hover relative overflow-hidden">
                                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="glass-effect px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                            <i class="fas fa-credit-card mr-1"></i>Virtual Card
                                        </div>
                                        <div class="text-sm flex items-center gap-2">
                                            <?php if ($card['is_active']): ?>
                                                <span class="glass-effect text-white px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                                    <i class="fas fa-check-circle mr-1"></i>Active
                                                </span>
                                            <?php else: ?>
                                                <span class="bg-red-500 bg-opacity-80 text-white px-3 py-1 rounded-full text-xs font-medium text-shadow">
                                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                                </span>
                                            <?php endif; ?>
                                            <form method="POST" action="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="toggle_card_status">
                                                <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="ml-2 px-2 py-1 rounded text-xs font-medium focus:outline-none focus:ring-2 focus:ring-white bg-white bg-opacity-10 hover:bg-opacity-20 text-white border border-white border-opacity-20">
                                                    <?php echo $card['is_active'] ? 'Set Inactive' : 'Set Active'; ?>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="text-lg font-bold mb-3 text-shadow tracking-wider">
                                        <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                                    </div>
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
                                    <div class="border-t border-white border-opacity-30 pt-4 space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm opacity-90 font-medium">Created</span>
                                            <span class="font-medium text-shadow"><?php echo date('M j, Y', strtotime($card['created_at'])); ?></span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm opacity-90 font-medium">Card ID</span>
                                            <span class="font-bold text-shadow text-green-200">#<?php echo $card['id']; ?></span>
                                        </div>
                                    </div>
                                    <!-- Card Balance Management -->
                                    <form method="POST" action="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>" class="mt-4">
                                        <input type="hidden" name="action" value="update_card_balance">
                                        <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <div class="grid grid-cols-2 gap-2 mb-3">
                                            <select name="card_balance_type" required class="w-full px-2 py-1 text-xs border border-white border-opacity-30 rounded bg-white bg-opacity-10 text-white">
                                                <option value="add">Add</option>
                                                <option value="subtract">Subtract</option>
                                            </select>
                                            <input type="number" name="card_amount" step="0.01" min="0.01" required 
                                                class="w-full px-2 py-1 text-xs border border-white border-opacity-30 rounded bg-white bg-opacity-10 text-white placeholder-white placeholder-opacity-75"
                                                placeholder="Amount">
                                        </div>
                                        <input type="text" name="card_description" 
                                            class="w-full px-2 py-1 text-xs border border-white border-opacity-30 rounded bg-white bg-opacity-10 text-white placeholder-white placeholder-opacity-75 mb-3"
                                            placeholder="Description">
                                        <button type="submit" class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-xs font-medium py-2 px-3 rounded transition duration-200">
                                            Update Balance
                                        </button>
                                    </form>
                                    <!-- Delete Card Button -->
                                    <form method="POST" action="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>" class="mt-2" onsubmit="return confirm('Are you sure you want to delete this card? This action cannot be undone.');">
                                        <input type="hidden" name="action" value="delete_card">
                                        <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="w-full bg-red-500 bg-opacity-80 hover:bg-red-600 text-white text-xs font-medium py-2 px-3 rounded transition duration-200 text-shadow">
                                            <i class="fas fa-trash mr-1"></i>Delete Card
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Record Transaction -->
            <div class="bg-white rounded-xl shadow-sm p-6 mt-8 border border-gray-100">
                <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-plus-circle mr-3 text-google-yellow"></i>Record Transaction
                </h3>
                
                <form method="POST" action="?page=admin&action=record_transaction">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Transaction Type</label>
                            <select name="transaction_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                                <option value="account_topup">Account Topup</option>
                                <option value="card_load">Card Load</option>
                                <option value="card_usage">Card Usage</option>
                                <option value="card_purchase">Card Purchase</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Card (if applicable)</label>
                            <select name="card_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                                <option value="">No Card (Account Transaction)</option>
                                <?php foreach ($userCards as $card): ?>
                                    <option value="<?php echo $card['id']; ?>">
                                        <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?> 
                                        (Balance: $<?php echo number_format($card['balance'], 2); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Amount</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number" name="transaction_amount" step="0.01" required 
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                       placeholder="Enter amount">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Description</label>
                            <input type="text" name="transaction_description" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue"
                                   placeholder="Transaction description">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-google-yellow hover-bg-google-yellow text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Record Transaction
                    </button>
                </form>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mt-8 border border-gray-100">
                <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-history mr-3 text-google-yellow"></i>Recent Transactions
                </h3>
                
                <?php if (empty($userTransactions)): ?>
                    <p class="text-gray-500 text-center py-8">No transactions for this user.</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
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
                                <?php foreach ($userTransactions as $transaction): ?>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3">
                                            <?php if ($transaction['type'] === 'card_purchase'): ?>
                                                <span class="bg-google-blue text-white px-3 py-1 rounded-full text-xs font-medium">Card Purchase</span>
                                            <?php elseif ($transaction['type'] === 'card_load'): ?>
                                                <span class="bg-google-green text-white px-3 py-1 rounded-full text-xs font-medium">Card Load</span>
                                            <?php elseif ($transaction['type'] === 'account_topup'): ?>
                                                <span class="bg-google-yellow text-white px-3 py-1 rounded-full text-xs font-medium">Account Topup</span>
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
        <?php endif; ?>
    </div>
</body>
</html> 