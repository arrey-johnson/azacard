const mysql = require('mysql2/promise');
const { logger } = require('../utils/logger');

// Create connection pool
const pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  port: parseInt(process.env.DB_PORT) || 3306,
  database: process.env.DB_NAME || 'azacard',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || undefined,
  waitForConnections: true,
  connectionLimit: 20,
  queueLimit: 0,
  acquireTimeout: 60000,
  timeout: 60000,
  reconnect: true,
  charset: 'utf8mb4',
  timezone: '+00:00'
});

// Test the connection
const testConnection = async () => {
  try {
    const connection = await pool.getConnection();
    logger.info('Connected to MySQL database');
    connection.release();
  } catch (error) {
    logger.error('Database connection failed:', error);
    throw error;
  }
};

const connectDB = async () => {
  try {
    await testConnection();
    logger.info('Database connection established successfully');
  } catch (error) {
    logger.error('Database connection failed:', error);
    throw error;
  }
};

// Helper function to run queries
const query = async (sql, params = []) => {
  const start = Date.now();
  try {
    const [rows, fields] = await pool.execute(sql, params);
    const duration = Date.now() - start;
    logger.debug('Executed query', { sql, duration, rows: rows.length });
    return { rows, fields };
  } catch (error) {
    logger.error('Query error:', error);
    throw error;
  }
};

// Helper function to get a connection for transactions
const getConnection = async () => {
  return await pool.getConnection();
};

// Helper function to run transactions
const transaction = async (callback) => {
  const connection = await getConnection();
  try {
    await connection.beginTransaction();
    const result = await callback(connection);
    await connection.commit();
    return result;
  } catch (error) {
    await connection.rollback();
    throw error;
  } finally {
    connection.release();
  }
};

module.exports = {
  connectDB,
  query,
  getConnection,
  transaction,
  pool
}; 