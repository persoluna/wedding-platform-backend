# Wedding Event Planning Platform
## Introduction, Objective & Project Scope

---

## Introduction

The wedding industry in India is a multi-billion dollar market with complex vendor ecosystems and diverse service requirements. Traditional wedding planning involves extensive research, multiple vendor coordination, and time-consuming communication processes. Couples often struggle to find reliable vendors within their budget and location, while agencies and vendors face challenges in reaching their target audience effectively.

This project aims to develop a comprehensive digital platform that bridges the gap between wedding service providers and couples seeking wedding planning services. The platform will serve as a centralized hub where agencies can manage their vendor networks, vendors can showcase their services, and couples can discover and connect with suitable wedding service providers through intelligent matching algorithms.

The system addresses the growing need for digitization in the wedding planning industry while incorporating modern technologies such as AI-powered recommendations, responsive web design, and efficient administrative management tools.

---

## Objective

### Primary Objective
To develop a web-based wedding event planning platform that connects agencies, vendors, and couples through an intelligent vendor matching system, streamlining the wedding planning process for all stakeholders.

### Secondary Objectives
- **For Agencies**: Provide tools to efficiently manage vendor networks, track inquiries, and grow their business reach within the local market
- **For Vendors**: Enable easy profile management, showcase portfolios, and facilitate communication with partner agencies
- **For Couples**: Offer free access to AI-powered vendor recommendations and seamless inquiry submission to connect with suitable agencies
- **For Platform**: Create a scalable, maintainable system that can expand to multiple regions and incorporate advanced features

### Technical Objectives
- Implement a modern full-stack web application using Laravel Filament for backend administration and Next.js for frontend user experience
- Develop an intelligent vendor matching algorithm that provides personalized recommendations based on user requirements
- Create a user-friendly interface that works seamlessly across desktop and mobile devices
- Build a secure, role-based authentication system supporting multiple user types
- Design a scalable architecture that supports future enhancements including payment integration and advanced AI features

---

## Project Scope

### Geographic Scope
- **Target Region**: Single county in India
- **Language Support**: English language interface
- **Market Focus**: Indian wedding traditions, customs, and vendor categories

### Functional Scope

#### Included Features
- **User Management**: Multi-tier user system (Super Admin, Agency, Vendor, Client)
- **Vendor Directory**: Comprehensive listing of wedding service providers with India-specific categories
- **AI-Powered Matching**: Intelligent vendor recommendation system based on user requirements
- **Administrative Panel**: Laravel Filament-based backend for system management
- **Client Interface**: Next.js frontend with Google OAuth authentication
- **Communication System**: Vendor-agency messaging and client inquiry management
- **Search & Discovery**: Advanced filtering and location-based vendor search
- **Analytics Dashboard**: Performance tracking and business insights

#### Excluded Features (Future Scope)
- **Payment Processing**: Online payment and transaction management
- **Multi-language Support**: Regional language interfaces
- **Advanced AI**: Machine learning-based recommendation improvements
- **Mobile Application**: Native iOS/Android applications
- **Multi-region Support**: Expansion beyond single county

### Technical Scope
- **Backend**: Laravel framework with Filament admin panel
- **Frontend**: Next.js with TypeScript and modern React features
- **Database**: MySQL/PostgreSQL with optimized query structures
- **Authentication**: Dual authentication system (email/password for admin, Google OAuth for clients)
- **Deployment**: Web-based platform accessible via modern browsers
- **Integration Ready**: Structured for future payment gateway and advanced AI service integration

### User Scope
- **Target Users**: Wedding agencies, individual vendors, couples planning weddings
- **User Base**: Local market within the specified county
- **Access Levels**: Free browsing for guests, authenticated access for inquiries, administrative access for business users

### Super Admin Features

*   **User Management:**
    *   Create, edit, and delete users.
    *   Assign roles and permissions to users.
*   **Agency Management:**
    *   Approve or reject agency applications.
    *   View and manage all agencies on the platform.
*   **Vendor Management:**
    *   View and manage all vendors on the platform.
*   **Category Management:**
    *   Create, edit, and delete service categories.
*   **Platform Analytics:**
    *   View platform-wide analytics and reports.

# Building and Running

## Setup

To set up the project for the first time, run the following command:

```bash
composer run setup
```

This will install all the required dependencies, create a `.env` file, generate an application key, run database migrations, and build the frontend assets.

## Development

To start the development server, run the following command:

```bash
composer run dev
```

This will start the Laravel development server, a queue worker, and a Vite server for frontend development. The admin panel is accessible at `/admin`.

## Testing

To run the test suite, use the following command:

```bash
composer run test
```

# Development Conventions

## Code Style

This project uses Laravel Pint for code styling. To format the code, run:

```bash
./vendor/bin/pint
```

## Database Migrations

Database migrations are located in the `database/migrations` directory. To create a new migration, run:

```bash
php artisan make:migration <migration_name>
```

To run the migrations, run:

```bash
php artisan migrate
```

## Filament

The Filament admin panel is configured in `app/Providers/Filament/AdminPanelProvider.php`. Resources, pages, and widgets are automatically discovered from the `app/Filament` directory.