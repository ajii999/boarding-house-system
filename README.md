# Boarding House Management System

A comprehensive web-based management system for boarding houses built with Laravel 11 and modern UI/UX design using Tailwind CSS.

## Features

### 🔐 Authentication & Authorization
- **Role-based access control** (Admin, Tenant, Staff)
- **Secure login system** with session management
- **User registration** for tenants
- **Middleware protection** for different user roles

### 👨‍💼 Admin Features
- **Tenant Management**: Add, view, edit, delete tenant records
- **Room Management**: Manage room availability, pricing, and details
- **Booking Management**: Oversee all room reservations and bookings
- **Payment Management**: Track and manage all payments
- **Invoice Generation**: Create and send invoices to tenants
- **Reports & Analytics**: Generate occupancy rate, revenue, and payment history reports
- **Maintenance Oversight**: Monitor and manage maintenance requests

### 🏠 Tenant Features
- **Profile Management**: Update personal information and contact details
- **Room Reservation**: Browse available rooms and make bookings
- **Payment History**: View payment records and transaction history
- **Invoice Access**: Download and view invoices
- **Maintenance Requests**: Submit and track maintenance issues
- **Notifications**: Receive payment reminders and booking alerts

### 🔧 Staff Features
- **Task Assignment**: View assigned tasks and update status
- **Maintenance Tracking**: Monitor and complete maintenance requests
- **Task Notifications**: Receive alerts for new tasks and updates
- **Progress Reporting**: Update task completion status

## Technology Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Icons**: Font Awesome 6
- **Authentication**: Custom session-based authentication

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM (for frontend assets)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd boardinghouse
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

6. **Access the application**
   - Open your browser and go to `http://localhost:8000`
   - The application will redirect to the login page

## Default Login Credentials

### Admin Account
- **Email**: admin@boardinghouse.com
- **Password**: admin123
- **Role**: Administrator

### Sample Tenant Accounts
- **Email**: john@example.com
- **Password**: password123
- **Role**: Tenant

- **Email**: jane@example.com
- **Password**: password123
- **Role**: Tenant

### Sample Staff Account
- **Email**: sarah@boardinghouse.com
- **Password**: (No password set - contact admin)
- **Role**: Staff

## Database Schema

The system includes the following main entities:

- **Admins**: System administrators
- **Tenants**: Boarding house residents
- **Staff**: Maintenance and support staff
- **Rooms**: Available accommodation units
- **Profiles**: Extended tenant information
- **Bookings**: Room reservations
- **Payments**: Financial transactions
- **MaintenanceRequests**: Service requests
- **Tasks**: Staff assignments
- **Notifications**: System alerts
- **Invoices**: Billing documents
- **Reports**: Analytics and reporting

## Key Features Implementation

### 🎨 Modern UI/UX Design
- **Responsive design** that works on all devices
- **Clean, professional interface** with intuitive navigation
- **Color-coded dashboards** for different user roles
- **Interactive elements** with hover effects and transitions
- **Consistent design language** across all pages

### 📊 Dashboard Analytics
- **Real-time statistics** for each user role
- **Visual data representation** with cards and charts
- **Quick action buttons** for common tasks
- **Recent activity feeds** for better user experience

### 🔒 Security Features
- **Password hashing** using Laravel's built-in hashing
- **CSRF protection** on all forms
- **Input validation** and sanitization
- **Role-based access control** with middleware
- **Session management** for secure authentication

### 📱 Responsive Design
- **Mobile-first approach** for optimal mobile experience
- **Flexible grid layouts** that adapt to different screen sizes
- **Touch-friendly interface** elements
- **Optimized navigation** for mobile devices

## File Structure

```
boardinghouse/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Http/Middleware/     # Custom middleware
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/            # Sample data
├── resources/
│   └── views/              # Blade templates
│       ├── admin/          # Admin-specific views
│       ├── tenant/         # Tenant-specific views
│       ├── staff/          # Staff-specific views
│       ├── auth/           # Authentication views
│       └── layouts/        # Layout templates
└── routes/
    └── web.php             # Application routes
```

## Usage Guide

### For Administrators
1. **Login** with admin credentials
2. **Manage tenants** - Add, edit, or remove tenant records
3. **Manage rooms** - Add new rooms, update pricing, check availability
4. **Oversee bookings** - Monitor all reservations and their status
5. **Track payments** - View payment history and generate reports
6. **Generate reports** - Create occupancy and revenue reports

### For Tenants
1. **Register** for a new account or login
2. **Update profile** - Keep personal information current
3. **Browse rooms** - View available accommodations
4. **Make bookings** - Reserve rooms for specific dates
5. **Track payments** - Monitor payment history and invoices
6. **Request maintenance** - Report issues or request services

### For Staff
1. **Login** with staff credentials
2. **View tasks** - Check assigned maintenance tasks
3. **Update progress** - Mark tasks as completed or in-progress
4. **Monitor maintenance** - Track maintenance requests
5. **Receive notifications** - Stay updated on new assignments

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions, please contact the development team or create an issue in the repository.

## Future Enhancements

- [ ] Email notifications system
- [ ] Advanced reporting with charts
- [ ] Mobile app integration
- [ ] Payment gateway integration
- [ ] Multi-language support
- [ ] Advanced search and filtering
- [ ] Document upload functionality
- [ ] Calendar integration for bookings