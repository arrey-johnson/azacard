<?php

class Transaction {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($data) {
        $sql = "INSERT INTO transactions (user_id, card_id, type, amount, description, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $this->db->query($sql, [
            $data['user_id'],
            $data['card_id'],
            $data['type'],
            $data['amount'],
            $data['description']
        ]);
        
        return $this->db->lastInsertId();
    }

    public function findByUser($userId, $limit = 50) {
        $sql = "SELECT t.*, c.card_number 
                FROM transactions t 
                LEFT JOIN cards c ON t.card_id = c.id 
                WHERE t.user_id = ? 
                ORDER BY t.created_at DESC 
                LIMIT " . intval($limit);
        return $this->db->fetchAll($sql, [$userId]);
    }

    public function findByCard($cardId, $userId, $limit = 50) {
        $sql = "SELECT * FROM transactions 
                WHERE card_id = ? AND user_id = ? 
                ORDER BY created_at DESC 
                LIMIT " . intval($limit);
        return $this->db->fetchAll($sql, [$cardId, $userId]);
    }

    public function getTotalByType($userId, $type) {
        $sql = "SELECT SUM(amount) as total FROM transactions 
                WHERE user_id = ? AND type = ?";
        $result = $this->db->fetch($sql, [$userId, $type]);
        return $result ? $result['total'] : 0;
    }

    public function getAllTransactions() {
        $sql = "SELECT t.*, u.name as user_name, u.email as user_email, c.card_number 
                FROM transactions t 
                LEFT JOIN users u ON t.user_id = u.id 
                LEFT JOIN cards c ON t.card_id = c.id 
                ORDER BY t.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getRecentTransactions($limit = 10) {
        $sql = "SELECT t.*, u.name as user_name, u.email as user_email, c.card_number 
                FROM transactions t 
                LEFT JOIN users u ON t.user_id = u.id 
                LEFT JOIN cards c ON t.card_id = c.id 
                ORDER BY t.created_at DESC 
                LIMIT " . intval($limit);
        return $this->db->fetchAll($sql);
    }

    public function getTotalTransactions() {
        $sql = "SELECT COUNT(*) as total FROM transactions";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }
}
?>