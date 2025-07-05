<?php

class Card {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($userId, $amount, $manualDetails = null) {
        if ($manualDetails) {
            // Use manually provided card details
            $cardNumber = $manualDetails['card_number'];
            $cvv = $manualDetails['cvv'];
            $expiryDate = $manualDetails['expiry_date'];
            $cardName = $manualDetails['card_name'] ?? '';
            $zipCode = $manualDetails['zip_code'] ?? '';
            $address = $manualDetails['address'] ?? '';
        } else {
            // Generate card details automatically
            $cardNumber = $this->generateCardNumber();
            $cvv = $this->generateCVV();
            $expiryDate = $this->generateExpiryDate();
            $cardName = '';
            $zipCode = '';
            $address = '';
        }
        
        $sql = "INSERT INTO cards (user_id, card_number, cvv, expiry_date, balance, card_name, zip_code, address, is_active, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())";
        
        $this->db->query($sql, [
            $userId,
            $cardNumber,
            $cvv,
            $expiryDate,
            $amount,
            $cardName,
            $zipCode,
            $address
        ]);
        
        return [
            'id' => $this->db->lastInsertId(),
            'card_number' => $cardNumber,
            'cvv' => $cvv,
            'expiry_date' => $expiryDate,
            'balance' => $amount,
            'card_name' => $cardName,
            'zip_code' => $zipCode,
            'address' => $address,
            'is_active' => 1
        ];
    }

    public function findByUser($userId) {
        $sql = "SELECT * FROM cards WHERE user_id = ? ORDER BY created_at DESC";
        $result = $this->db->fetchAll($sql, [$userId]);
        return $result ?: [];
    }

    public function findById($cardId, $userId) {
        $sql = "SELECT * FROM cards WHERE id = ? AND user_id = ?";
        return $this->db->fetch($sql, [$cardId, $userId]);
    }

    public function updateBalance($cardId, $userId, $amount) {
        $sql = "UPDATE cards SET balance = balance + ? WHERE id = ? AND user_id = ?";
        return $this->db->query($sql, [$amount, $cardId, $userId]);
    }

    public function getBalance($cardId, $userId) {
        $sql = "SELECT balance FROM cards WHERE id = ? AND user_id = ?";
        $result = $this->db->fetch($sql, [$cardId, $userId]);
        return $result ? $result['balance'] : 0;
    }

    public function toggleStatus($cardId, $userId) {
        $sql = "UPDATE cards SET is_active = NOT is_active WHERE id = ? AND user_id = ?";
        return $this->db->query($sql, [$cardId, $userId]);
    }

    public function delete($cardId, $userId) {
        // First check if card exists and belongs to user
        $card = $this->findById($cardId, $userId);
        if (!$card) {
            return false;
        }
        
        // Delete the card
        $sql = "DELETE FROM cards WHERE id = ? AND user_id = ?";
        return $this->db->query($sql, [$cardId, $userId]);
    }

    public function deleteById($cardId) {
        // Admin delete - no user restriction
        $sql = "DELETE FROM cards WHERE id = ?";
        return $this->db->query($sql, [$cardId]);
    }

    private function generateCardNumber() {
        // Generate a 16-digit card number
        $cardNumber = '';
        for ($i = 0; $i < 16; $i++) {
            $cardNumber .= rand(0, 9);
        }
        return $cardNumber;
    }

    private function generateCVV() {
        // Generate a 3-digit CVV
        return str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
    }

    private function generateExpiryDate() {
        // Generate expiry date (3 years from now)
        $year = date('Y') + 3;
        $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        return $month . '/' . substr($year, -2);
    }

    public function validateCard($cardId, $userId) {
        $card = $this->findById($cardId, $userId);
        return $card && $card['is_active'] == 1;
    }

    public function getAllCards() {
        $sql = "SELECT c.*, u.name as user_name, u.email as user_email 
                FROM cards c 
                LEFT JOIN users u ON c.user_id = u.id 
                ORDER BY c.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function getRecentCards($limit = 10) {
        $sql = "SELECT c.*, u.name as user_name, u.email as user_email 
                FROM cards c 
                LEFT JOIN users u ON c.user_id = u.id 
                ORDER BY c.created_at DESC 
                LIMIT " . intval($limit);
        return $this->db->fetchAll($sql);
    }

    public function getTotalCards() {
        $sql = "SELECT COUNT(*) as total FROM cards";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }

    public function getTotalCardBalance() {
        $sql = "SELECT SUM(balance) as total FROM cards";
        $result = $this->db->fetch($sql);
        return $result ? $result['total'] : 0;
    }

    public function getTotalSales() {
        $sql = "SELECT COUNT(*) as total FROM cards";
        $result = $this->db->fetch($sql);
        $count = $result ? $result['total'] : 0;
        return $count * 5.39;
    }
}
?>