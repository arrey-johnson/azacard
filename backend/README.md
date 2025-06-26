# Azacard Backend API

A comprehensive virtual card system backend built with Node.js, Express, and MySQL. This API provides user management, KYC verification, virtual card issuance, payment processing, and admin dashboard functionality.

## Features

- 🔐 **Authentication & Authorization**: JWT-based authentication with role-based access control
- 👤 **User Management**: Registration, login, profile management, and KYC verification
- 💳 **Virtual Card System**: Card issuance, balance management, and transaction tracking
- 💰 **Payment Processing**: Mobile Money integration (MoMo, Orange Money) for loading and withdrawals
- 📊 **Admin Dashboard**: User management, transaction monitoring, and system configuration
- 🔒 **Security**: Rate limiting, input validation, error handling, and logging
- 📝 **API Documentation**: Swagger/OpenAPI documentation

## Tech Stack

- **Runtime**: Node.js (>=18.0.0)
- **Framework**: Express.js
- **Database**: MySQL
- **Authentication**: JWT + bcrypt
- **Validation**: Joi
- **Logging**: Winston
- **Documentation**: Swagger/OpenAPI

## Prerequisites

- Node.js >= 18.0.0
- MySQL >= 8.0
- npm or yarn

## Quick Start

### 1. Clone and Setup

```bash
# Navigate to backend directory
cd backend

# Run the setup script (installs dependencies, runs migrations, seeds database)
npm run setup
```

### 2. Configure Environment

Copy the environment template and update with your settings:

```bash
cp env.example .env
```

Update the `.env` file with your database credentials and other settings:

```env
# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_USER=your_username
DB_PASSWORD=your_password
DB_NAME=azacard_db

# JWT Configuration
JWT_SECRET=your_jwt_secret_key
JWT_EXPIRES_IN=24h

# Server Configuration
PORT=3000
NODE_ENV=development

# Admin Configuration
ADMIN_EMAIL=admin@azacard.com
ADMIN_PASSWORD=admin123

# Payment Gateway Configuration
MOMO_API_KEY=your_momo_api_key
MOMO_API_SECRET=your_momo_secret
ORANGE_MONEY_API_KEY=your_orange_money_api_key
ORANGE_MONEY_API_SECRET=your_orange_money_secret
```

### 3. Start the Server

```bash
# Development mode (with auto-reload)
npm run dev

# Production mode
npm start
```

The server will start on `http://localhost:3000`

### 4. Test the API

```bash
# Run API tests
npm run test:api
```

## API Endpoints

### Authentication
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `GET /api/auth/profile` - Get user profile
- `PUT /api/auth/profile` - Update user profile
- `POST /api/auth/verify-email` - Verify email address
- `POST /api/auth/verify-phone` - Verify phone number

### KYC Management
- `POST /api/auth/kyc` - Submit KYC documents
- `GET /api/auth/kyc` - Get KYC status
- `PUT /api/admin/kyc/:userId` - Approve/reject KYC (admin)

### Virtual Cards
- `POST /api/cards` - Request new virtual card
- `GET /api/cards` - Get user's cards
- `GET /api/cards/:cardId` - Get specific card details
- `PUT /api/cards/:cardId/block` - Block/unblock card
- `DELETE /api/cards/:cardId` - Delete card

### Payments
- `POST /api/payments/load` - Load funds to card
- `POST /api/payments/withdraw` - Withdraw funds from card
- `GET /api/payments/transactions` - Get transaction history
- `GET /api/payments/balance` - Get card balance

### Admin (Protected)
- `GET /api/admin/users` - Get all users
- `GET /api/admin/users/:userId` - Get specific user
- `PUT /api/admin/users/:userId` - Update user
- `GET /api/admin/transactions` - Get all transactions
- `GET /api/admin/config` - Get system configuration
- `PUT /api/admin/config` - Update system configuration

## Database Schema

The system includes the following main tables:

- **users**: User accounts and profiles
- **kyc_documents**: KYC verification documents
- **virtual_cards**: Virtual card information
- **transactions**: Payment transactions
- **config**: System configuration
- **admin_actions**: Admin activity logs

## Development

### Project Structure

```
backend/
├── src/
│   ├── config/          # Database and app configuration
│   ├── database/        # Database migrations and seeds
│   ├── middleware/      # Express middleware
│   ├── routes/          # API route handlers
│   ├── utils/           # Utility functions
│   └── server.js        # Main server file
├── logs/                # Application logs
├── .env                 # Environment variables
├── package.json         # Dependencies and scripts
└── README.md           # This file
```

### Available Scripts

- `npm start` - Start production server
- `npm run dev` - Start development server with auto-reload
- `npm run setup` - Complete setup (install, migrate, seed)
- `npm run migrate` - Run database migrations
- `npm run seed` - Seed database with initial data
- `npm run test:api` - Test API endpoints
- `npm run lint` - Run ESLint
- `npm run lint:fix` - Fix ESLint issues

### Database Management

```bash
# Run migrations
npm run migrate

# Seed database
npm run seed

# Reset database (drop and recreate)
npm run migrate:reset
```

## Security Features

- **Rate Limiting**: Prevents abuse with configurable limits
- **Input Validation**: All inputs validated with Joi schemas
- **Password Hashing**: bcrypt with configurable salt rounds
- **JWT Authentication**: Secure token-based authentication
- **CORS Protection**: Configurable cross-origin resource sharing
- **Helmet Security**: Security headers and protection
- **Error Handling**: Comprehensive error handling and logging

## Logging

The application uses Winston for logging with the following levels:
- **error**: Application errors
- **warn**: Warning messages
- **info**: General information
- **debug**: Debug information (development only)

Logs are written to both console and files in the `logs/` directory.

## Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `PORT` | Server port | 3000 |
| `NODE_ENV` | Environment mode | development |
| `DB_HOST` | MySQL host | localhost |
| `DB_PORT` | MySQL port | 3306 |
| `DB_USER` | MySQL username | - |
| `DB_PASSWORD` | MySQL password | - |
| `DB_NAME` | MySQL database name | azacard_db |
| `JWT_SECRET` | JWT signing secret | - |
| `JWT_EXPIRES_IN` | JWT expiration time | 24h |
| `BCRYPT_ROUNDS` | Password hashing rounds | 12 |
| `ADMIN_EMAIL` | Default admin email | admin@azacard.com |
| `ADMIN_PASSWORD` | Default admin password | admin123 |

## API Documentation

Once the server is running, you can access the interactive API documentation at:
- Swagger UI: `http://localhost:3000/api-docs`
- OpenAPI JSON: `http://localhost:3000/api-docs.json`

## Testing

```bash
# Test API endpoints
npm run test:api

# Run unit tests (if configured)
npm test
```

## Deployment

### Production Checklist

1. Set `NODE_ENV=production`
2. Use strong `JWT_SECRET`
3. Configure production database
4. Set up proper logging
5. Configure reverse proxy (nginx)
6. Set up SSL/TLS certificates
7. Configure firewall rules
8. Set up monitoring and alerts

### Docker Deployment

```dockerfile
FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm ci --only=production
COPY . .
EXPOSE 3000
CMD ["npm", "start"]
```

## Support

For issues and questions:
1. Check the logs in the `logs/` directory
2. Verify environment variables are set correctly
3. Ensure MySQL is running and accessible
4. Check API documentation for endpoint details

## License

This project is proprietary software developed by Bao Technologies. 