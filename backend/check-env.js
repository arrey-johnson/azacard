require('dotenv').config();

console.log('🔍 Checking environment variables...\n');

const envVars = {
  'DB_HOST': process.env.DB_HOST,
  'DB_PORT': process.env.DB_PORT,
  'DB_NAME': process.env.DB_NAME,
  'DB_USER': process.env.DB_USER,
  'DB_PASSWORD': process.env.DB_PASSWORD ? '[SET]' : '[NOT SET]',
  'NODE_ENV': process.env.NODE_ENV,
  'PORT': process.env.PORT
};

console.log('Database Configuration:');
Object.entries(envVars).forEach(([key, value]) => {
  console.log(`  ${key}: ${value}`);
});

console.log('\n📝 If DB_PASSWORD shows [NOT SET], that\'s correct for XAMPP with no root password.');
console.log('📝 If you see any issues, please check your .env file in the backend directory.'); 