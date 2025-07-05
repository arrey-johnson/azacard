<?php
require_once __DIR__ . '/index.php';
require_once __DIR__ . '/app/Database.php';
require_once __DIR__ . '/app/Admin.php';

$admin = new Admin();

$data = [
    'username' => 'support',
    'email' => 'support@zapkard.shop',
    'password' => 'support237',
    'name' => 'Support',
    'role' => 'admin'
];

$result = $admin->create($data);

if ($result) {
    echo "Admin user created successfully.\n";
} else {
    echo "Failed to create admin user.\n";
} 