# SocietySphere - Housing Society Management System

A comprehensive web-based housing society management system built with PHP, HTML, CSS, and JavaScript that facilitates seamless communication between residents and committee members.

## 🌟 Features

### 👥 Multi-Role System
- **Resident Portal**: Access to notices, events, polls, gallery, complaints, and maintenance tracking
- **Committee Portal**: Administrative access for managing all society operations
- **Secure Authentication**: Role-based access control with password protection

### 🏠 Core Modules

#### 📋 **Notices Management**
- Upload and view PDF notices (Committee)
- Real-time notice updates
- File size validation (max 5MB)

#### 📅 **Events Calendar**
- Create and manage society events
- Event scheduling with dates and times
- Upcoming events display

#### 📊 **Polling System**
- Create interactive polls with multiple options
- Real-time voting with results visualization
- Poll expiration management

#### 🖼️ **Gallery**
- Photo upload and management
- PNG/JPEG support with file validation
- Responsive gallery layout

#### ⚠️ **Complaints System**
- Submit and track complaint status
- Status history tracking
- Committee response management

#### 💰 **Maintenance Tracking**
- Monthly maintenance and parking fee tracking
- Payment status management (Paid/Unpaid)
- Financial reporting

#### 📚 **Resident Directory**
- Complete resident information
- Privacy-protected contact details
- Building and room-based organization

### 🎯 **Dashboard Features**
- Real-time activity feed
- Quick statistics overview
- Recent updates and notifications

## 🛠️ Technology Stack

### Frontend
- **HTML5** - Semantic structure
- **CSS3** - Responsive design with media queries
- **JavaScript** - Dynamic content loading and interactions
- **Responsive Design** - Mobile-first approach

### Backend
- **PHP** - Server-side processing
- **MySQL** - Database management
- **AJAX** - Asynchronous data loading
- **Session Management** - Secure user authentication

## 📁 Project Structure

```
society-management/
├── code.php              # Backend logic
├── website.php           # Frontend interface
├── Titlelogo.png         # Application logo
├── HomeLogo.png          # Tab icons
├── AboutUsLogo.png
├── DirectoryLogo.png
├── NoticeLogo.png
├── EventLogo.png
├── PollLogo.png
├── GalleryLogo.png
├── ComplaintLogo.png
├── MaintenanceLogo.png
└── README.md            # This file
```

## 🚀 Installation & Setup

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

## 🚀 How to Use
- Clone the repository:
```bash
git clone https://github.com/your-username/HousingSociety.git
```

- Open `website.php` in your web browser


### Deployment
1. Upload all files to your web server
2. Ensure proper file permissions
3. Configure web server to serve `website.php` as the main entry point
4. Access the application via your domain

## 👤 User Roles & Permissions

### Resident
- View notices, events, polls, and gallery
- Submit and track complaints
- Check maintenance payment status
- Access resident directory (with privacy protection)

### Committee Member
- All resident permissions plus:
- Upload and manage notices
- Create and manage events
- Create and manage polls
- Upload gallery photos
- Process resident complaints
- Update maintenance payment status
- Access complete resident directory

## 🔒 Security Features

- Password hashing using `password_hash()`
- Session-based authentication
- Input validation and sanitization
- File type and size validation
- Role-based access control
- SQL injection prevention with prepared statements

## 📱 Responsive Design

The application is fully responsive and optimized for:
- **Desktop** (1024px+)
- **Tablet** (768px - 1024px)
- **Mobile** (320px - 768px)

## 🎨 UI/UX Features

- **Color Scheme**: Purple and lavender theme for professional appearance
- **Tab-based Navigation**: Intuitive interface organization
- **Loading States**: Smooth user experience during data fetching
- **Error Handling**: Comprehensive error messages and validation
- **Accessibility**: ARIA labels and semantic HTML

## 🔄 AJAX Implementation

- Dynamic content loading without page refresh
- Real-time updates for activities and statistics
- Form submissions with immediate feedback
- Poll voting without page reload

## 📊 Database Schema

Key tables include:
- `users` - Resident and committee member information
- `notices` - Society announcements and documents
- `events` - Event calendar management
- `polls` & `poll_options` & `poll_votes` - Voting system
- `gallery` - Photo storage and metadata
- `complaints` - Issue tracking with status history
- `maintenance` - Payment records and status

## 🚀 Usage Guide

### For Residents
1. **Registration**: Create account with building and room details
2. **Login**: Access personalized dashboard
3. **Navigation**: Use tab-based interface to access different features
4. **Complaints**: Submit issues and track resolution progress
5. **Maintenance**: Check payment status monthly

### For Committee Members
1. **Content Management**: Upload notices, events, and photos
2. **Poll Creation**: Engage residents with interactive polls
3. **Complaint Resolution**: Update status and communicate progress
4. **Financial Tracking**: Monitor maintenance payments
5. **Directory Access**: Complete resident information

## 🔧 Customization

### Adding New Features
1. Update backend logic in `code.php`
2. Add frontend interface in `website.php`
3. Extend database schema as needed
4. Update role permissions accordingly

### Styling Modifications
- Primary colors can be modified in CSS variables
- Responsive breakpoints in media queries
- Tab icons can be replaced in the image assets

## 📞 Support

For technical support or feature requests, please contact the system administrator or refer to the application documentation.

## 📄 License

This project is proprietary software developed for housing society management. All rights reserved.

---

**SocietySphere** - Building Connected Communities Through Technology 🏘️💻
