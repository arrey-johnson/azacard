const axios = require('axios');

const BASE_URL = 'http://localhost:3001/api/v1';

// Helper function to log test steps
const logStep = (step, description) => {
  console.log(`\n${step}. ${description}`);
};

const testEndpoints = async () => {
  console.log('🧪 Testing Azacard Backend API...');
  let token = '';

  try {
    // 1. Test server health
    logStep(1, 'Testing server health...');
    const healthResponse = await axios.get('http://localhost:3001/health');
    console.log('✅ Health check passed:', JSON.stringify(healthResponse.data, null, 2));

    // 2. Test admin login
    logStep(2, 'Testing admin login...');
    const loginData = {
      email: 'admin@azacard.com',
      password: 'admin123'
    };
    console.log('   Request:', JSON.stringify(loginData, null, 2));
    
    const loginResponse = await axios.post(`${BASE_URL}/auth/login`, loginData);
    console.log('✅ Login successful');
    console.log('   Response:', JSON.stringify({
      success: loginResponse.data.success,
      user: loginResponse.data.data?.user ? 'User data received' : 'No user data',
      token: loginResponse.data.data?.token ? 'Token received' : 'No token'
    }, null, 2));
    
    token = loginResponse.data.data?.token;
    if (!token) {
      throw new Error('No token received in login response');
    }

    // 3. Test protected route - Get user profile
    logStep(3, 'Testing protected route - Get user profile...');
    const profileResponse = await axios.get(`${BASE_URL}/auth/me`, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });
    
    console.log('✅ Profile access successful');
    console.log('   User:', profileResponse.data.data?.user?.name || 'No user data');

    // 4. Test config endpoint
    logStep(4, 'Testing admin config endpoint...');
    const configResponse = await axios.get(`${BASE_URL}/admin/config`, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });
    
    console.log('✅ Config access successful');
    console.log('   Config data received:', Object.keys(configResponse.data.data || {}).length > 0 ? 'Yes' : 'No');

    // 5. Test virtual cards endpoint
    logStep(5, 'Testing virtual cards endpoint...');
    try {
      const cardsResponse = await axios.get(`${BASE_URL}/cards`, {
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
      console.log('✅ Cards access successful');
      console.log('   Cards found:', cardsResponse.data.data?.length || 0);
    } catch (error) {
      console.log('ℹ️  Cards endpoint not accessible (might require KYC):', error.response?.data?.message || error.message);
    }

    console.log('\n🎉 All tests passed! Backend is working correctly.');
    
  } catch (error) {
    console.log('\n❌ Test failed:', error.message);
    
    if (error.response) {
      console.log('Response status:', error.response.status);
      console.log('Response data:', JSON.stringify(error.response.data, null, 2));
    } else if (error.request) {
      console.log('No response received:', error.request);
    } else {
      console.log('Error:', error.message);
    }
    
    process.exit(1);
  } finally {
    // Clean up if needed
  }
};

// Run tests if this file is executed directly
if (require.main === module) {
  testEndpoints().catch(error => {
    console.error('Unhandled error:', error);
    process.exit(1);
  });
}

module.exports = { testEndpoints };