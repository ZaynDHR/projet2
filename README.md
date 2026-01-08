# BugTracker - Bug Tracking System

A lightweight, open-source bug tracking application built with PHP and vanilla JavaScript.

## Overview

BugTracker is a simple yet effective bug tracking system designed to help teams manage, prioritize, and resolve issues efficiently. It provides an intuitive interface for creating tickets, tracking progress, and collaborating on bug fixes.

## Features

### Current Features
- ✅ User Authentication (Login & Sign Up)
- ✅ Create, Read, Update, Delete Tickets (CRUD)
- ✅ Ticket Status Management (Open, In Progress, Closed)
- ✅ Priority Levels (Low, Medium, High, Critical)
- ✅ Dashboard with Statistics
- ✅ Quick Filters (All, My Tickets, High Priority, Open, Closed, Resolved)
- ✅ Ticket Search & Filter
- ✅ Responsive Design

### Planned Features
- 🔜 Ticket Assignment to Team Members
- 🔜 Comments on Tickets
- 🔜 Activity History & Timeline
- 🔜 User Roles (Admin, Manager, Developer)
- 🔜 Email Notifications
- 🔜 File Attachments
- 🔜 Advanced Reporting & Analytics
- 🔜 Dark Mode

## Tech Stack

- **Backend**: PHP 8.2
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Server**: Apache (XAMPP)

## Project Structure

```
projet2/
├── public/
│   ├── css/
│   │   ├── dashboard.css
│   │   ├── login.css
│   │   ├── signup.css
│   │   └── ticket-form.css
│   └── js/
│       ├── dashboard.js
│       ├── login.js
│       ├── signup.js
│       └── ticket-form.js
├── src/
│   ├── classes/
│   │   ├── Auth.php
│   │   ├── Database.php
│   │   ├── Ticket.php
│   │   └── User.php
│   └── config/
│       └── config.php
├── pages/
│   ├── dashboard.php
│   ├── login.php
│   ├── signup.php
│   ├── ticket-form.php
│   ├── delete-ticket.php
│   ├── update-ticket.php
│   └── logout.php
├── database/
│   └── database.sql
├── index.php
├── seeder.php
└── README.md
```

## Installation & Setup

### Prerequisites
- XAMPP (Apache, MySQL, PHP 8.2+)
- Git (optional)

### Steps

1. **Clone or Download the Project**
   ```bash
   cd c:\xampp\htdocs
   git clone <repository-url> projet2
   cd projet2
   ```

2. **Set Up Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `bugtracker`
   - Import `database.sql` file:
     ```sql
     mysql -u root -p bugtracker < database.sql
     ```

3. **Configure Database Connection**
   - Open `src/config/config.php`
   - Update database credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASSWORD', '');
     define('DB_NAME', 'bugtracker');
     ```

4. **Start XAMPP**
   - Start Apache and MySQL services
   - Open browser: `http://localhost/projet2`

5. **Create Your First Account**
   - Go to: `http://localhost/projet2/pages/signup.php`
   - Fill in your details (minimum 8 character password required)
   - Click Register
   - Login with your credentials

## Usage Guide

### Dashboard
- View all active tickets
- See ticket statistics and overview
- Filter tickets by status, priority
- Click on a ticket to view details

### Creating a Ticket
1. Click **Create Ticket** button on dashboard
2. Fill in:
   - Title (required)
   - Description (required)
   - Category (Bug, Feature, Improvement)
   - Priority (Low, Medium, High, Critical)
3. Click **Save Ticket**

### Editing a Ticket
1. Click on a ticket to select it (left panel)
2. Click the **Edit button (✎)**
3. Update the fields in the modal
4. Click **Save Changes**

### Deleting a Ticket
1. Click on a ticket to select it
2. Click the **Delete button (✕)**
3. Confirm deletion

### Filtering Tickets
Use the Quick Filters section:
- **All Tickets** - Show all tickets
- **My Tickets** - Show your reported tickets
- **High Priority** - Show high priority tickets
- **Open** - Show open tickets
- **Closed** - Show closed tickets
- **Resolved** - Show resolved tickets

## API Endpoints

### Ticket Management
- `GET /pages/dashboard.php` - View dashboard
- `POST /pages/ticket-form.php` - Create ticket
- `POST /pages/update-ticket.php` - Update ticket
- `POST /pages/delete-ticket.php?id=<id>` - Delete ticket

### Authentication
- `GET /pages/signup.php` - Sign up page
- `POST /pages/signup.php` - Register user
- `GET /index.php` - Login page
- `POST /index.php` - Authenticate user
- `GET /pages/logout.php` - Logout

## Database Schema

### Users Table
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tickets Table
```sql
CREATE TABLE tickets (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  description TEXT,
  category VARCHAR(50),
  priority VARCHAR(20),
  status VARCHAR(20),
  reporter_id INT,
  assignee_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (reporter_id) REFERENCES users(id),
  FOREIGN KEY (assignee_id) REFERENCES users(id)
);
```

## Default Credentials

If you run the seeder:
```bash
php seeder.php
```

Test Account:
- **Email**: test@example.com
- **Password**: Test123

## Password Requirements

- Minimum 8 characters
- Must match confirmation password

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## License

This project is open source and available under the MIT License.

## Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Contact: support@bugtracker.local

## Roadmap

### v2.0
- Team collaboration features
- Advanced filtering and search
- Ticket assignment system
- Comments and activity log

### v3.0
- User roles and permissions
- Email notifications
- File attachments
- API documentation

### v4.0
- Mobile app
- Real-time updates
- Advanced analytics
- Integrations (GitHub, GitLab, Jira)

## Changelog

### v1.0 (Current)
- Initial release
- Basic CRUD operations
- Authentication system
- Dashboard and statistics
- Quick filters
- Edit and delete functionality

---

**Made with ❤️ by BugTracker Team**
