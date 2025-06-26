const axios = require('axios');

const BASE_URL = 'http://localhost:3001/api/v1';

const testEndpoints = async () => {
  console.log('🧪 Testing Azacard Backend API...\n');

  try {
    // Test server health
    console.log('1. Testing server health...');
    const healthResponse = await axios.get('http://localhost:3001/health');
    console.log('✅ Health check passed:', healthResponse.data);

    // Test admin login
    console.log('\n2. Testing admin login...');
    const loginResponse = await axios.post(`${BASE_URL}/auth/login`, {
      email: 'admin@azacard.com',
      password: 'admin123'
    });
    console.log('✅ Admin login successful');
    
    const token = loginResponse.data.token;

    // Test protected route
    console.log('\n3. Testing protected route...');
    const profileResponse = await axios.get(`${BASE_URL}/auth/me`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    console.log('✅ Profile access successful:', profileResponse.data.data.user.name);

    // Test config endpoint
    console.log('\n4. Testing config endpoint...');
    const configResponse = await axios.get(`${BASE_URL}/admin/config`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    console.log('✅ Config access successful');

    console.log('\n🎉 All tests passed! Backend is working correctly.');
    
  } catch (error) {
    console.log('\n❌ Test failed:', error.message);
    if (error.response) {
      console.log('Response status:', error.response.status);
      console.log('Response data:', error.response.data);
    }
    process.exit(1);
  }
};

// Run tests if this file is executed directly
if (require.main === module) {
  testEndpoints();
}

module.exports = { testEndpoints }; 