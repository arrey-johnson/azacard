-- Create database if not exists
CREATE DATABASE IF NOT EXISTS azacard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE azacard;

-- Create users table
CREATE TABLE users (
  id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  phone VARCHAR(20) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  kyc_status ENUM('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'PENDING',
  id_type VARCHAR(50),
  id_number VARCHAR(100),
  selfie_image_url VARCHAR(500),
  email_verified BOOLEAN DEFAULT FALSE,
  phone_verified BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_phone (phone),
  INDEX idx_kyc_status (kyc_status)
);

-- Create virtual_cards table
CREATE TABLE virtual_cards (
  id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
  user_id CHAR(36) NOT NULL,
  card_number VARCHAR(16) UNIQUE,
  pin_hash VARCHAR(255),
  currency VARCHAR(3) NOT NULL DEFAULT 'XAF',
  status ENUM('PENDING', 'ACTIVE', 'SUSPENDED') DEFAULT 'PENDING',
  balance DECIMAL(18,2) DEFAULT 0.00,
  daily_withdrawal_limit DECIMAL(18,2) DEFAULT 50000.00,
  monthly_withdrawal_limit DECIMAL(18,2) DEFAULT 500000.00,
  daily_withdrawal_used DECIMAL(18,2) DEFAULT 0.00,
  monthly_withdrawal_used DECIMAL(18,2) DEFAULT 0.00,
  last_withdrawal_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_user_id (user_id),
  INDEX idx_card_number (card_number),
  INDEX idx_status (status)
);

-- Create transactions table
CREATE TABLE transactions (
  id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
  card_id CHAR(36) NOT NULL,
  type ENUM('LOAD', 'WITHDRAW', 'CARD_ISSUANCE') NOT NULL,
  amount DECIMAL(18,2) NOT NULL,
  channel ENUM('MOMO', 'OM'),
  external_ref VARCHAR(255),
  description TEXT,
  status ENUM('PENDING', 'SUCCESS', 'FAILED') DEFAULT 'PENDING',
  fee_amount DECIMAL(18,2) DEFAULT 0.00,
  net_amount DECIMAL(18,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (card_id) REFERENCES virtual_cards(id) ON DELETE CASCADE,
  INDEX idx_card_id (card_id),
  INDEX idx_type (type),
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
);

-- Create config table for system configuration
CREATE TABLE config (
  `key` VARCHAR(100) PRIMARY KEY,
  value JSON NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create audit_logs table for compliance
CREATE TABLE audit_logs (
  id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
  user_id CHAR(36),
  action VARCHAR(100) NOT NULL,
  resource_type VARCHAR(50),
  resource_id CHAR(36),
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  user_agent TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_user_id (user_id),
  INDEX idx_created_at (created_at)
);

-- Insert default configuration
INSERT INTO config (`key`, value, description) VALUES
('card_issuance_fee', '{"XAF": 500}', 'Card issuance fee by currency'),
('min_load_amount', '{"XAF": 1000}', 'Minimum load amount by currency'),
('max_daily_withdrawal', '{"XAF": 50000}', 'Maximum daily withdrawal by currency'),
('max_monthly_withdrawal', '{"XAF": 500000}', 'Maximum monthly withdrawal by currency'),
('transaction_fees', '{"load": {"percentage": 0.5, "min": 50}, "withdraw": {"percentage": 1.0, "min": 100}}', 'Transaction fees configuration'),
('kyc_requirements', '{"id_types": ["national_id", "passport", "drivers_license"], "required_fields": ["name", "phone", "id_type", "id_number", "selfie"]}', 'KYC requirements configuration'); 