const fs = require('fs');
const path = require('path');
const { query, connectDB } = require('../config/database');
const { logger } = require('../utils/logger');

const runMigrations = async () => {
  try {
    // Connect to database
    await connectDB();
    logger.info('Connected to database for migrations');

    // Read and execute migration files
    const migrationsDir = path.join(__dirname, 'migrations');
    const migrationFiles = fs.readdirSync(migrationsDir)
      .filter(file => file.endsWith('.sql'))
      .sort();

    for (const file of migrationFiles) {
      logger.info(`Running migration: ${file}`);
      
      const migrationPath = path.join(migrationsDir, file);
      const migrationSQL = fs.readFileSync(migrationPath, 'utf8');
      
      // Split SQL by semicolon and execute each statement
      const statements = migrationSQL
        .split(';')
        .map(stmt => stmt.trim())
        .filter(stmt => stmt.length > 0 && !stmt.startsWith('--'));

      for (const statement of statements) {
        if (statement.trim()) {
          try {
            // Skip USE statements as they're not supported in prepared statements
            if (statement.toUpperCase().startsWith('USE ')) {
              logger.info(`Skipping: ${statement}`);
              continue;
            }
            
            // Skip CREATE TYPE statements as MySQL doesn't support custom types like PostgreSQL
            if (statement.toUpperCase().startsWith('CREATE TYPE ')) {
              logger.info(`Skipping PostgreSQL type creation: ${statement}`);
              continue;
            }
            
            await query(statement);
            logger.info(`Executed: ${statement.substring(0, 50)}...`);
          } catch (error) {
            // Skip if table already exists or other non-critical errors
            if (error.code === 'ER_TABLE_EXISTS_ERROR' || error.code === 'ER_DUP_KEYNAME') {
              logger.warn(`Skipped (already exists): ${statement.substring(0, 50)}...`);
            } else {
              throw error;
            }
          }
        }
      }
    }

    logger.info('All migrations completed successfully');
    process.exit(0);
  } catch (error) {
    logger.error('Migration failed:', error);
    process.exit(1);
  }
};

// Run migrations if this file is executed directly
if (require.main === module) {
  runMigrations();
}

module.exports = { runMigrations }; 