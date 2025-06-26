const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

console.log('🚀 Setting up Azacard Backend...\n');

// Check if .env file exists
if (!fs.existsSync('.env')) {
  console.log('📝 Creating .env file from template...');
  if (fs.existsSync('env.example')) {
    fs.copyFileSync('env.example', '.env');
    console.log('✅ .env file created. Please update it with your database credentials.');
  } else {
    console.log('❌ env.example not found. Please create a .env file manually.');
  }
}

// Install dependencies
console.log('\n📦 Installing dependencies...');
try {
  execSync('npm install', { stdio: 'inherit' });
  console.log('✅ Dependencies installed successfully.');
} catch (error) {
  console.log('❌ Failed to install dependencies:', error.message);
  process.exit(1);
}

// Create logs directory
console.log('\n📁 Creating logs directory...');
if (!fs.existsSync('logs')) {
  fs.mkdirSync('logs');
  console.log('✅ Logs directory created.');
}

// Run migrations
console.log('\n🗄️  Running database migrations...');
try {
  execSync('node src/database/migrate.js', { stdio: 'inherit' });
  console.log('✅ Database migrations completed.');
} catch (error) {
  console.log('❌ Failed to run migrations:', error.message);
  console.log('Please ensure your MySQL database is running and .env file is configured correctly.');
  process.exit(1);
}

// Seed database
console.log('\n🌱 Seeding database...');
try {
  execSync('node src/database/seed.js', { stdio: 'inherit' });
  console.log('✅ Database seeded successfully.');
} catch (error) {
  console.log('❌ Failed to seed database:', error.message);
  process.exit(1);
}

console.log('\n🎉 Setup completed successfully!');
console.log('\nTo start the server:');
console.log('  npm start');
console.log('\nTo start in development mode:');
console.log('  npm run dev');
console.log('\nDefault admin credentials:');
console.log('  Email: admin@azacard.com');
console.log('  Password: admin123');
console.log('\nPlease change these credentials in production!'); 