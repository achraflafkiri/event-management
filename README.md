# Event Management System

A Laravel-based event management application that allows users to create, view, and manage events with RSVP functionality.

## 🚀 Quick Start

### Prerequisites
- PHP 8.0 or higher
- Composer
- Node.js & NPM
- MySQL database

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/achraflafkiri/event-management.git
   cd event-management
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   npm run build
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=event_management
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Create database and run migrations**
   ```bash
   # Create database in MySQL
   mysql -u your_username -p
   CREATE DATABASE event_management;
   exit;
   
   # Run migrations
   php artisan migrate
   ```

7. **Seed database with test data**
   ```bash
   php artisan db:seed
   ```

8. **Start the application**
   ```bash
   php artisan serve
   ```
   
   Visit: `http://localhost:8000`

## 👤 Test Accounts

**Admin User:**
- Email: `admin@example.com`
- Password: `password`
- Can: Create, edit, delete events

**Regular User:**
- Email: `user@example.com`
- Password: `password`
- Can: View events and RSVP

## ✨ Features

### User Features
- **View Events**: Browse upcoming events with details
- **Filter & Sort**: Filter by location, sort by date/name
- **RSVP System**: Register for events with capacity limits
- **User Authentication**: Secure login/registration

### Admin Features  
- **Event Management**: Create, edit, delete events
- **Attendee Management**: View RSVP lists
- **Capacity Control**: Set RSVP limits for events

### Technical Features
- **Responsive Design**: Works on desktop and mobile
- **Form Validation**: Server-side validation for all forms
- **Role-based Access**: Admin vs regular user permissions
- **API Endpoints**: RESTful API for future integrations

## 🛠 Built With

- **Backend**: Laravel 12
- **Frontend**: Blade Templates + Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Validation**: Laravel Form Requests
- **Authorization**: Laravel Middleware

## 📁 Project Structure

```
event-management-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── EventController.php      # Main event management
│   │   ├── RsvpController.php       # RSVP functionality
│   │   └── Api/EventController.php  # API endpoints
│   ├── Models/
│   │   ├── User.php                 # User model with roles
│   │   ├── Event.php               # Event model
│   │   └── Rsvp.php                # RSVP model
│   └── Http/Requests/              # Form validation
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Test data
├── resources/
│   └── views/
│       ├── events/                 # Event views
│       └── layouts/                # Layout templates
└── routes/
    ├── web.php                     # Web routes
    └── api.php                     # API routes
```

## 🌐 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/events` | Get all events |
| POST | `/api/events` | Create new event (admin) |
| GET | `/api/events/{id}` | Get event details |
| PUT | `/api/events/{id}` | Update event (admin) |
| DELETE | `/api/events/{id}` | Delete event (admin) |
| POST | `/api/events/{id}/rsvp` | RSVP to event |

## 🔧 Configuration

### Mail Configuration (Optional)
For password reset functionality, configure mail in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Cache Configuration
```bash
# Clear caches during development
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 📝 Database Schema

### Users Table
- `id`, `name`, `email`, `password`, `role` (admin/user)

### Events Table  
- `id`, `name`, `description`, `location`, `event_date`, `rsvp_limit`, `created_by`

### RSVPs Table
- `id`, `user_id`, `event_id`, `created_at`

## 🐛 Troubleshooting

**Database Connection Error:**
- Verify database credentials in `.env`
- Ensure MySQL service is running
- Check if database exists

**Permission Errors:**
- Run: `chmod -R 775 storage bootstrap/cache`

**Missing Dependencies:**
- Run: `composer install` and `npm install`

**App Key Missing:**
- Run: `php artisan key:generate`

Enjoy! 🎉 :) Thank you POWER GROUP Team