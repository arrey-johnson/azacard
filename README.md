# ZapKard - PHP MVC Virtual Card System

A simple and modern virtual card management system built with PHP MVC architecture. Users can buy virtual cards, load funds, and check balances with a beautiful, responsive interface.

## 🚀 Features

- **User Authentication**: Secure login and registration system
- **Virtual Card Management**: Buy, load, and manage virtual cards
- **Balance Tracking**: Real-time balance checking for cards and accounts
- **Transaction History**: Complete transaction logging and history
- **Modern UI**: Beautiful, responsive design with Tailwind CSS
- **AJAX Integration**: Smooth, dynamic user experience
- **Security**: Password hashing, session management, and input validation

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- Web server (Apache/Nginx)
- XAMPP/WAMP/MAMP (for local development)

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd zapkard
```

### 2. Database Setup
1. Start your MySQL server (XAMPP/WAMP/MAMP)
2. Open phpMyAdmin or MySQL command line
3. Import the database schema:
   ```sql
   -- Option 1: Using phpMyAdmin
   - Create a new database named 'google_cards'
   - Import the database.sql file
   
   -- Option 2: Using command line
   mysql -u root -p < database.sql
   ```

### 3. Configure Database Connection
Edit the database configuration in `index.php`:
```php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'google_cards');
define('DB_USER', 'root');        // Your MySQL username
define('DB_PASS', '');            // Your MySQL password
```

### 4. Web Server Configuration

#### Apache (.htaccess)
Create a `.htaccess` file in the root directory:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Nginx
Add this to your nginx configuration:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 5. Start the Application
1. Place the project in your web server directory
2. Access the application: `http://localhost/zapkard`

## 📁 Project Structure

```
zapkard/
├── app/                    # Application logic
│   ├── Database.php       # Database connection class
│   ├── User.php           # User model
│   ├── Card.php           # Card model
│   ├── Transaction.php    # Transaction model
│   ├── HomeController.php # Home page controller
│   ├── AuthController.php # Authentication controller
│   ├── DashboardController.php # Dashboard controller
│   └── CardController.php # Card operations controller
├── views/                 # View templates
│   ├── home.php          # Landing page
│   ├── login.php         # Login page
│   ├── register.php      # Registration page
│   ├── dashboard.php     # Main dashboard
│   ├── cards.php         # Cards listing
│   ├── buy-card.php      # Buy card page
│   ├── load-card.php     # Load card page
│   ├── check-balance.php # Check balance page
│   └── 404.php           # Error page
├── index.php             # Main entry point and router
├── database.sql          # Database schema
└── README.md             # This file
```

## 🎯 Usage

### 1. Registration & Login
- Visit the homepage and click "Get Started"
- Register with your name, email, and password
- Login with your credentials

### 2. Buy Virtual Cards
- From the dashboard, click "Buy New Card"
- Enter the amount you want to load on the card
- The system will generate a unique card number, CVV, and expiry date
- The amount will be deducted from your account balance

### 3. Load Cards
- Click "Load Card" from the dashboard
- Select an existing card from the dropdown
- Enter the amount to add
- The funds will be transferred from your account to the card

### 4. Check Balances
- Use "Check Balance" to view individual card balances
- View all your cards and their current balances
- See transaction history for each card

## 🔧 API Endpoints

The system includes AJAX endpoints for dynamic functionality:

- `POST /api/cards/buy` - Purchase a new virtual card
- `POST /api/cards/load` - Load funds to an existing card
- `POST /api/cards/balance` - Check card balance

## 🎨 Customization

### Styling
The application uses Tailwind CSS for styling. You can customize the design by:
- Modifying the Tailwind classes in the view files
- Adding custom CSS in the `<head>` section
- Replacing the Tailwind CDN with a local installation

### Features
To add new features:
1. Create new models in the `app/` directory
2. Add controllers for new functionality
3. Create view files in the `views/` directory
4. Update the routing in `index.php`

## 🔒 Security Features

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()`
- **Session Management**: Secure session handling with user authentication
- **Input Validation**: Form validation and sanitization
- **SQL Injection Prevention**: Prepared statements for all database queries
- **XSS Protection**: HTML escaping for user input

## 🚀 Deployment

### Local Development
1. Use XAMPP/WAMP/MAMP for local development
2. Ensure mod_rewrite is enabled for Apache
3. Set proper file permissions

### Production Deployment
1. Upload files to your web server
2. Configure your web server (Apache/Nginx)
3. Set up the database on your production server
4. Update database credentials in `index.php`
5. Ensure HTTPS is enabled for security

## 🐛 Troubleshooting

### Common Issues

1. **404 Errors**: Ensure mod_rewrite is enabled and .htaccess is working
2. **Database Connection**: Check database credentials and server status
3. **AJAX Not Working**: Verify the API endpoints are accessible
4. **Styling Issues**: Check if Tailwind CSS is loading properly

### Debug Mode
To enable debug mode, add this to `index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For support or questions:
- Create an issue in the repository
- Check the troubleshooting section
- Review the code comments for implementation details

---

**ZapKard** - Your Digital Financial Freedom 🚀 