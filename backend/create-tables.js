require('dotenv').config();
const { query } = require('./src/config/database');

const createTables = async () => {
  try {
    console.log('Creating tables...');
    
    // Create users table
    await query(`
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
      )
    `);
    console.log('✅ Users table created');

    // Create virtual_cards table
    await query(`
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
      )
    `);
    console.log('✅ Virtual cards table created');

    // Create transactions table
    await query(`
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
      )
    `);
    console.log('✅ Transactions table created');

    // Create config table
    await query(`
      CREATE TABLE config (
        \`key\` VARCHAR(100) PRIMARY KEY,
        value JSON NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )
    `);
    console.log('✅ Config table created');

    // Create audit_logs table
    await query(`
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
      )
    `);
    console.log('✅ Audit logs table created');

    console.log('🎉 All tables created successfully!');
    
  } catch (error) {
    console.error('❌ Error creating tables:', error.message);
    if (error.code === 'ER_TABLE_EXISTS_ERROR') {
      console.log('Tables already exist, that\'s fine!');
    }
  }
};

createTables(); 