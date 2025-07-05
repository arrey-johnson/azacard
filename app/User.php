<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, username, email, phone, password, balance, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->db->query($sql, [
            $data['name'],
            $data['username'],
            $data['email'],
            $data['phone'],
            $hashedPassword,
            0.00
        ]);
        
        return $this->db->lastInsertId();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        return $this->db->fetch($sql, [$username]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function updateBalance($userId, $amount) {
        $sql = "UPDATE users SET balance = balance + ? WHERE id = ?";
        return $this->db->query($sql, [$amount, $userId]);
    }

    public function getBalance($userId) {
        $sql = "SELECT balance FROM users WHERE id = ?";
        $result = $this->db->fetch($sql, [$userId]);
        return $result ? $result['balance'] : 0;
    }

    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    public function storeResetToken($userId, $token, $expires) {
        $sql = "UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?";
        return $this->db->query($sql, [$token, $expires, $userId]);
    }

    public function findByResetToken($token) {
        $sql = "SELECT * FROM users WHERE reset_token = ?";
        return $this->db->fetch($sql, [$token]);
    }

    public function updatePassword($userId, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        return $this->db->query($sql, [$hashedPassword, $userId]);
    }

    public function clearResetToken($userId) {
        $sql = "UPDATE users SET reset_token = NULL, reset_expires = NULL WHERE id = ?";
        return $this->db->query($sql, [$userId]);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getRecentUsers($limit = 10) {
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT " . intval($limit);
        return $this->db->fetchAll($sql);
    }

    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }

    public function getTotalBalance() {
        $sql = "SELECT SUM(balance) as total FROM users";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }


}
?>