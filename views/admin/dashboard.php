<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ZapKard</title>
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
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex flex-col sm:flex-row sm:items-end gap-1 sm:gap-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-google-blue to-google-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white text-lg"></i>
                        </div>
                        <span class="text-2xl font-medium" style="font-family: 'Roboto', sans-serif;">
                            <span style="color: #4285F4;">Z</span><span style="color: #EA4335;">a</span><span style="color: #FBBC05;">p</span><span style="color: #4285F4;">K</span><span style="color: #34A853;">a</span><span style="color: #EA4335;">r</span><span style="color: #4285F4;">d</span>
                        </span>
                    </div>
                    <span class="text-sm text-gray-500 ml-0 sm:ml-2">Admin Panel</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-right sm:text-left">
                    <span class="text-gray-600 whitespace-nowrap">Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                    <a href="?page=admin-logout" class="bg-google-red hover-bg-google-red text-white px-4 py-2 rounded-lg transition duration-200 font-medium flex items-center justify-center w-full sm:w-auto">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Admin Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap sm:flex-nowrap space-x-0 sm:space-x-8 overflow-x-auto">
                <a href="?page=admin" class="py-3 px-2 border-b-2 border-google-blue text-google-blue font-medium whitespace-nowrap">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="?page=admin&action=users" class="py-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                    <i class="fas fa-users mr-2"></i>Users
                </a>
                <a href="?page=admin&action=cards" class="py-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                    <i class="fas fa-credit-card mr-2"></i>Cards
                </a>
                <a href="?page=admin&action=transactions" class="py-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                    <i class="fas fa-history mr-2"></i>Transactions
                </a>
                <a href="?page=admin&action=marketing_campaigns" class="py-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                    <i class="fas fa-bullhorn mr-2"></i>Send Campaigns
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 sm:px-4 py-6 sm:py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-google-blue rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-sm">Total Users</h3>
                        <p class="text-2xl font-medium text-gray-900"><?php echo number_format($stats['total_users']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-google-green rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-credit-card text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-sm">Total Cards</h3>
                        <p class="text-2xl font-medium text-gray-900"><?php echo number_format($stats['total_cards']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-google-yellow rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-exchange-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-sm">Transactions</h3>
                        <p class="text-2xl font-medium text-gray-900"><?php echo number_format($stats['total_transactions']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-google-blue rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-wallet text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-sm">Total Balance</h3>
                        <p class="text-2xl font-medium text-gray-900">$<?php echo number_format($stats['total_balance'] ?? 0, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-google-yellow rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-600 font-medium text-sm">Total Sales</h3>
                        <p class="text-2xl font-medium text-gray-900">$<?php echo number_format($stats['total_sales'] ?? 0, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Recent Activity -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-users mr-3 text-google-blue"></i>Recent Users
                </h2>
                
                <?php if (empty($recentUsers)): ?>
                    <p class="text-gray-500 text-center py-4">No users yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recentUsers as $user): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($user['email']); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$<?php echo number_format($user['balance'] ?? 0, 2); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($user['created_at'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="?page=admin&action=users" class="text-google-blue hover:text-google-blue font-medium text-sm">
                            View all users
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Cards -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-credit-card mr-3 text-google-green"></i>Recent Cards
                </h2>
                
                <?php if (empty($recentCards)): ?>
                    <p class="text-gray-500 text-center py-4">No cards yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recentCards as $card): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        <?php echo substr($card['card_number'], 0, 4) . ' **** **** ' . substr($card['card_number'], -4); ?>
                                    </p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($card['user_name']); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$<?php echo number_format($card['balance'] ?? 0, 2); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($card['created_at'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="?page=admin&action=cards" class="text-google-blue hover:text-google-blue font-medium text-sm">
                            View all cards
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-history mr-3 text-google-yellow"></i>Recent Transactions
                </h2>
                
                <?php if (empty($recentTransactions)): ?>
                    <p class="text-gray-500 text-center py-4">No transactions yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($recentTransactions as $transaction): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        <?php 
                                        switch ($transaction['type']) {
                                            case 'card_purchase':
                                                echo 'Card Purchase';
                                                break;
                                            case 'card_load':
                                                echo 'Card Load';
                                                break;
                                            case 'account_topup':
                                                echo 'Account Topup';
                                                break;
                                            default:
                                                echo ucfirst($transaction['type']);
                                        }
                                        ?>
                                    </p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($transaction['user_name']); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium <?php echo $transaction['amount'] < 0 ? 'text-red-600' : 'text-green-600'; ?>">
                                        <?php echo ($transaction['amount'] < 0 ? '-' : '+') . '$' . number_format(abs($transaction['amount'] ?? 0), 2); ?>
                                    </p>
                                    <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($transaction['created_at'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="?page=admin&action=transactions" class="text-google-blue hover:text-google-blue font-medium text-sm">
                            View all transactions
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 