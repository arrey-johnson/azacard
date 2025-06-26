# Virtual Card System

A comprehensive virtual card management system with React frontend and Node.js backend, supporting Mobile Money (MoMo) and Orange Money integrations.

## 🚀 Features

- **User Onboarding & KYC**: Complete user registration with identity verification
- **Virtual Card Issuance**: Multi-currency virtual card creation
- **Payment Integration**: MoMo and Orange Money support for loading and withdrawals
- **Real-time Balance**: Live balance inquiry and transaction history
- **Admin Dashboard**: Comprehensive monitoring and management tools
- **Security**: PCI-DSS compliant with encrypted card data

## 🏗️ Architecture

```
┌──────────┐       ┌────────────┐       ┌───────────────┐
│ Frontend │←→ API │ Backend    │←→ Webhooks & │
│ (React)  │       │ (Node.js)  │   Payment APIs │
└──────────┘       └────────────┘       └───────────────┘
         ↑                                   ↑
         │                                   │
     Browser                              MoMo/Orange Money
```

## 🛠️ Tech Stack

### Frontend
- **React 18** with TypeScript
- **Vite** for build tooling
- **React Query** for state management
- **React Hook Form** + **Yup** for form handling
- **Tailwind CSS** for styling
- **Axios** for HTTP requests

### Backend
- **Node.js** with Express
- **MySQL** database
- **JWT** authentication
- **Bcrypt** for password hashing
- **Joi** for validation

### Infrastructure
- **Docker** containerization
- **GitHub Actions** for CI/CD
- **AWS** deployment ready

## 📁 Project Structure

```
azacard/
├── frontend/          # React + Vite application
├── backend/           # Node.js Express API
├── database/          # Database migrations and seeds
├── docs/             # Documentation
└── docker-compose.yml # Local development setup
```

## 🚀 Quick Start

### Prerequisites
- Node.js 18+
- MySQL 8.0+
- Docker (optional)

### Local Development

1. **Clone and setup:**
   ```bash
   git clone <repository-url>
   cd azacard
   ```

2. **Setup MySQL database:**
   ```bash
   # Create database
   mysql -u root -p
   CREATE DATABASE azacard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Configure environment:**
   ```bash
   cd backend
   cp env.example .env
   # Edit .env with your MySQL credentials
   ```

4. **Run database migrations:**
   ```bash
   cd backend
   npm install
   npm run migrate
   ```

5. **Start backend:**
   ```bash
   npm run dev
   ```

6. **Start frontend:**
   ```bash
   cd ../frontend
   npm install
   npm run dev
   ```

### Docker Setup

```bash
docker-compose up -d
```

## 📚 API Documentation

The API documentation is available at `/api/docs` when the backend is running.

### Key Endpoints

- **Authentication**: `/api/v1/auth/*`
- **Cards**: `/api/v1/cards/*`
- **Payments**: `/api/v1/payments/*`
- **Admin**: `/api/v1/admin/*`

## 🔒 Security

- TLS 1.2+ encryption
- PCI-DSS compliant card data handling
- JWT token authentication
- Rate limiting and input validation
- Audit logging for all financial operations

## 📊 Monitoring

- Prometheus metrics
- Grafana dashboards
- Application logging
- Error tracking

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## 📄 License

This project is proprietary software developed by Bao Technologies.

## 📞 Support

For technical support or questions, please contact the development team. 