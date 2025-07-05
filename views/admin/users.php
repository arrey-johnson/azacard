<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - ZapKard Admin</title>
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
                    <a href="?page=admin&action=logout" class="bg-google-red hover-bg-google-red text-white px-4 py-2 rounded-lg transition duration-200 font-medium">
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
                <a href="?page=admin&action=users" class="py-4 px-2 border-b-2 border-google-blue text-google-blue font-medium">
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
        <h1 class="text-2xl font-bold mb-6">Users</h1>
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-light text-gray-900">Users Management</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="searchUsers" placeholder="Search users..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-google-blue">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <a href="?page=admin&action=create_user" 
                   class="bg-google-green hover-bg-google-green text-white px-4 py-2 rounded-lg transition duration-200 font-medium flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>Create User
                </a>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 overflow-x-auto">
            <div class="overflow-x-auto">
                <table class="w-full text-gray-900">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">User</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Username</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Email</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Phone</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Balance</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Joined</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-google-blue rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-medium text-sm">
                                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></p>
                                                <p class="text-sm text-gray-500">ID: <?php echo $user['id']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-900 font-mono">@<?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-900"><?php echo htmlspecialchars($user['email']); ?></p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-900"><?php echo htmlspecialchars($user['phone']); ?></p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium text-google-blue">$<?php echo number_format($user['balance'], 2); ?></span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-900"><?php echo date('M j, Y', strtotime($user['created_at'])); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo date('H:i', strtotime($user['created_at'])); ?></p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <a href="?page=admin&action=manage_user&id=<?php echo $user['id']; ?>" 
                                               class="bg-google-blue hover-bg-google-blue text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                                <i class="fas fa-edit mr-1"></i>Manage
                                            </a>
                                            <button onclick="viewUserDetails(<?php echo $user['id']; ?>)" 
                                                    class="bg-gray-500 hover-bg-gray-600 text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Details Modal -->
        <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">User Details</h3>
                    <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="userModalContent" class="p-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchUsers').addEventListener('input', function(e) {
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

        // User details modal
        function viewUserDetails(userId) {
            fetch(`?page=admin&action=api_get_user&id=${userId}`)
                .then(response => response.json())
                .then(user => {
                    const modal = document.getElementById('userModal');
                    const content = document.getElementById('userModalContent');
                    
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">${user.name}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Username</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">@${user.username || 'N/A'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">${user.email}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <p class="mt-1 text-sm text-gray-900">${user.phone}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Balance</label>
                                    <p class="mt-1 text-sm text-gray-900">$${parseFloat(user.balance).toFixed(2)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Joined</label>
                                    <p class="mt-1 text-sm text-gray-900">${new Date(user.created_at).toLocaleDateString()}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">User ID</label>
                                    <p class="mt-1 text-sm text-gray-900">${user.id}</p>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button onclick="closeUserModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded font-medium transition duration-200">
                                    Close
                                </button>
                                <a href="?page=admin&action=manage_user&id=${user.id}" class="bg-google-blue hover-bg-google-blue text-white px-4 py-2 rounded font-medium transition duration-200">
                                    Manage User
                                </a>
                            </div>
                        </div>
                    `;
                    
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load user details');
                });
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('userModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeUserModal();
            }
        });
    </script>
</body>
</html> 