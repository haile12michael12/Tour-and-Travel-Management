# Tour and Travel Management System

A modern PHP MVC-based web application for managing tour and travel bookings, destinations, and user accounts.

## Features

- User Authentication (Login/Register)
- Admin Panel
- Tour Booking System
- City and Country Management
- Responsive Design
- Secure Password Handling
- Session Management

## Technology Stack

- PHP 7.4+
- MySQL/MariaDB
- MVC Architecture
- PDO for Database Operations
- Composer for Dependency Management

## Directory Structure

```
├── app/
│   ├── Controllers/     # Application controllers
│   ├── Models/         # Database models
│   ├── Views/          # View templates
│   └── Core/           # Core framework classes
├── public/
│   ├── assets/         # CSS, JS, and images
│   └── index.php       # Application entry point
├── config/             # Configuration files
├── vendor/             # Composer dependencies
└── composer.json       # Composer configuration
```

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/tour-and-travel-management.git
cd tour-and-travel-management
```

2. Install dependencies:
```bash
composer install
```

3. Create a `.env` file in the root directory with the following content:
```
DB_HOST=localhost
DB_NAME=tour_travel_db
DB_USER=your_database_user
DB_PASS=your_database_password

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost
```

4. Import the database schema:
```bash
mysql -u your_database_user -p your_database_name < database/schema.sql
```

5. Configure your web server to point to the `public` directory.

## Database Structure

### Tables

1. **users**
   - id (Primary Key)
   - email
   - username
   - mypassword
   - created_at

2. **admins**
   - id (Primary Key)
   - adminname
   - email
   - mypassword
   - created_at

3. **countries**
   - id (Primary Key)
   - name
   - image
   - continent
   - population
   - territory
   - description
   - created_at

4. **cities**
   - id (Primary Key)
   - name
   - image
   - trip_days
   - price
   - country_id (Foreign Key)
   - created_at

5. **bookings**
   - id (Primary Key)
   - name
   - phone_number
   - num_of_geusts
   - checkin_date
   - destination
   - status
   - city_id (Foreign Key)
   - user_id (Foreign Key)
   - payment
   - created_at

## Usage

### User Features

1. **Registration**
   - Visit `/register`
   - Fill in email, username, and password
   - Submit form

2. **Login**
   - Visit `/login`
   - Enter email and password
   - Select user type (user/admin)
   - Submit form

3. **Booking**
   - Browse available destinations
   - Select dates and number of guests
   - Complete booking process

### Admin Features

1. **Dashboard**
   - View all bookings
   - Manage users
   - Add/Edit destinations
   - Process bookings

2. **Country Management**
   - Add new countries
   - Edit country details
   - Upload country images

3. **City Management**
   - Add new cities
   - Set prices and trip duration
   - Manage city images

## Security Features

- Password Hashing using PHP's password_hash()
- PDO Prepared Statements
- Input Validation
- XSS Prevention
- CSRF Protection
- Session Management

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email michaelhaile12@yahoo.com or create an issue in the repository.

## Acknowledgments

- PHP Community
- MVC Architecture Pattern
- All contributors who have helped shape this project