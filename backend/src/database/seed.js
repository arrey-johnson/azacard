const bcrypt = require('bcryptjs');
const { query, connectDB } = require('../config/database');
const { logger } = require('../utils/logger');

const seedDatabase = async () => {
  try {
    // Connect to database
    await connectDB();
    logger.info('Connected to database for seeding');

    // Check if admin user already exists
    const adminCheck = await query(
      'SELECT id FROM users WHERE email = ?',
      [process.env.ADMIN_EMAIL || 'admin@azacard.com']
    );

    if (adminCheck.rows.length === 0) {
      // Create admin user
      const saltRounds = parseInt(process.env.BCRYPT_ROUNDS) || 12;
      const passwordHash = await bcrypt.hash(
        process.env.ADMIN_PASSWORD || 'admin123', 
        saltRounds
      );

      await query(
        'INSERT INTO users (name, email, phone, password_hash, kyc_status, email_verified, phone_verified) VALUES (?, ?, ?, ?, ?, ?, ?)',
        [
          'Admin User',
          process.env.ADMIN_EMAIL || 'admin@azacard.com',
          '+1234567890',
          passwordHash,
          'APPROVED',
          true,
          true
        ]
      );

      logger.info('Admin user created successfully');
    } else {
      logger.info('Admin user already exists, skipping creation');
    }

    // Check if config already exists
    const configCheck = await query('SELECT COUNT(*) as count FROM config');
    
    if (parseInt(configCheck.rows[0].count) === 0) {
      // Insert default configuration
      const defaultConfig = [
        ['card_issuance_fee', '{"XAF": 500}', 'Card issuance fee by currency'],
        ['min_load_amount', '{"XAF": 1000}', 'Minimum load amount by currency'],
        ['max_daily_withdrawal', '{"XAF": 50000}', 'Maximum daily withdrawal by currency'],
        ['max_monthly_withdrawal', '{"XAF": 500000}', 'Maximum monthly withdrawal by currency'],
        ['transaction_fees', '{"load": {"percentage": 0.5, "min": 50}, "withdraw": {"percentage": 1.0, "min": 100}}', 'Transaction fees configuration'],
        ['kyc_requirements', '{"id_types": ["national_id", "passport", "drivers_license"], "required_fields": ["name", "phone", "id_type", "id_number", "selfie"]}', 'KYC requirements configuration']
      ];

      for (const [key, value, description] of defaultConfig) {
        await query(
          'INSERT INTO config (`key`, value, description) VALUES (?, ?, ?)',
          [key, value, description]
        );
      }

      logger.info('Default configuration inserted successfully');
    } else {
      logger.info('Configuration already exists, skipping insertion');
    }

    logger.info('Database seeding completed successfully');
    process.exit(0);
  } catch (error) {
    logger.error('Seeding failed:', error);
    process.exit(1);
  }
};

// Run seeding if this file is executed directly
if (require.main === module) {
  seedDatabase();
}

module.exports = { seedDatabase }; 