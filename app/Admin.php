<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function authenticate($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = ? AND is_active = 1";
        $admin = $this->db->fetch($sql, [$username]);
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Update last login
            $this->updateLastLogin($admin['id']);
            return $admin;
        }
        
        return false;
    }

    public function authenticateByEmail($email, $password) {
        $sql = "SELECT * FROM admins WHERE email = ? AND is_active = 1";
        $admin = $this->db->fetch($sql, [$email]);
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Update last login
            $this->updateLastLogin($admin['id']);
            return $admin;
        }
        
        return false;
    }

    public function findById($id) {
        $sql = "SELECT * FROM admins WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM admins WHERE username = ?";
        return $this->db->fetch($sql, [$username]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM admins WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }

    public function getAllAdmins() {
        $sql = "SELECT * FROM admins ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function create($data) {
        $sql = "INSERT INTO admins (username, email, password, name, role) VALUES (?, ?, ?, ?, ?)";
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $this->db->query($sql, [
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['name'],
            $data['role'] ?? 'admin'
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE admins SET username = ?, email = ?, name = ?, role = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        
        return $this->db->query($sql, [
            $data['username'],
            $data['email'],
            $data['name'],
            $data['role'],
            $id
        ]);
    }

    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE admins SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        return $this->db->query($sql, [$hashedPassword, $id]);
    }

    public function toggleStatus($id) {
        $sql = "UPDATE admins SET is_active = NOT is_active, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM admins WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    private function updateLastLogin($id) {
        $sql = "UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getTotalAdmins() {
        $sql = "SELECT COUNT(*) as total FROM admins";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }

    public function getActiveAdmins() {
        $sql = "SELECT COUNT(*) as total FROM admins WHERE is_active = 1";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }

    public function hasPermission($adminId, $permission) {
        $admin = $this->findById($adminId);
        if (!$admin) return false;

        // Super admin has all permissions
        if ($admin['role'] === 'super_admin') return true;

        // Define permissions for different roles
        $permissions = [
            'admin' => [
                'manage_users',
                'manage_cards', 
                'manage_transactions',
                'view_reports',
                'manage_balances'
            ],
            'moderator' => [
                'view_users',
                'view_cards',
                'view_transactions',
                'view_reports'
            ]
        ];

        return in_array($permission, $permissions[$admin['role']] ?? []);
    }
}
?>