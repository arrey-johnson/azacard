require('dotenv').config();
const { connectDB } = require('./src/config/database');

(async () => {
  try {
    await connectDB();
    console.log('✅ Database connection successful!');
    process.exit(0);
  } catch (e) {
    console.error('❌ Database connection failed:', e.message || e);
    process.exit(1);
  }
})(); 