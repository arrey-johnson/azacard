require('dotenv').config();
const { query } = require('./src/config/database');

(async () => {
  try {
    const result = await query('SHOW TABLES');
    console.log('Tables in database:');
    if (result.rows.length === 0) {
      console.log('No tables found!');
    } else {
      result.rows.forEach(row => {
        console.log('-', Object.values(row)[0]);
      });
    }
  } catch (error) {
    console.error('Error checking tables:', error.message);
  }
  process.exit(0);
})(); 