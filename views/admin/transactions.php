<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Management - ZapKard Admin</title>
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
                <a href="?page=admin&action=transactions" class="py-4 px-2 border-b-2 border-google-blue text-google-blue font-medium">
                    <i class="fas fa-history mr-2"></i>Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Transactions</h1>
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-light text-gray-900">Transactions Management</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="searchTransactions" placeholder="Search transactions..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 overflow-x-auto">
            <div class="overflow-x-auto">
                <table class="w-full text-gray-900">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Transaction</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">User</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Card</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Amount</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Type</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Date</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">No transactions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-6">
                                        <div>
                                            <p class="font-medium text-gray-900">#<?php echo $transaction['id']; ?></p>
                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($transaction['description']); ?></p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-google-blue rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-medium text-xs">
                                                    <?php echo strtoupper(substr($transaction['user_name'], 0, 1)); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo htmlspecialchars($transaction['user_name']); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($transaction['user_email']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <?php if ($transaction['card_number']): ?>
                                            <p class="font-medium text-gray-900">
                                                <?php echo substr($transaction['card_number'], 0, 4) . ' **** **** ' . substr($transaction['card_number'], -4); ?>
                                            </p>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-sm">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium <?php echo $transaction['amount'] < 0 ? 'text-red-600' : 'text-green-600'; ?>">
                                            <?php echo ($transaction['amount'] < 0 ? '-' : '+') . '$' . number_format(abs($transaction['amount']), 2); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <?php 
                                        $typeColors = [
                                            'card_purchase' => 'bg-google-blue',
                                            'card_load' => 'bg-google-green',
                                            'account_topup' => 'bg-google-yellow'
                                        ];
                                        $typeLabels = [
                                            'card_purchase' => 'Card Purchase',
                                            'card_load' => 'Card Load',
                                            'account_topup' => 'Account Topup'
                                        ];
                                        $color = $typeColors[$transaction['type']] ?? 'bg-gray-500';
                                        $label = $typeLabels[$transaction['type']] ?? ucfirst($transaction['type']);
                                        ?>
                                        <span class="<?php echo $color; ?> text-white px-3 py-1 rounded-full text-xs font-medium">
                                            <?php echo $label; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-900"><?php echo date('M j, Y', strtotime($transaction['created_at'])); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo date('H:i', strtotime($transaction['created_at'])); ?></p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="?page=admin&action=manage_user&id=<?php echo $transaction['user_id']; ?>" 
                                           class="bg-google-blue hover-bg-google-blue text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                            <i class="fas fa-user-edit mr-1"></i>View User
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transactions Summary -->
        <?php if (!empty($transactions)): ?>
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-medium text-gray-900 mb-4">Transactions Summary</h3>
                <div class="grid md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-google-blue"><?php echo count($transactions); ?></div>
                        <div class="text-sm text-gray-600">Total Transactions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-google-green">
                            <?php echo count(array_filter($transactions, function($t) { return $t['amount'] > 0; })); ?>
                        </div>
                        <div class="text-sm text-gray-600">Credits</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-google-red">
                            <?php echo count(array_filter($transactions, function($t) { return $t['amount'] < 0; })); ?>
                        </div>
                        <div class="text-sm text-gray-600">Debits</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-google-yellow">
                            $<?php echo number_format(array_sum(array_column($transactions, 'amount')), 2); ?>
                        </div>
                        <div class="text-sm text-gray-600">Net Amount</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchTransactions').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 