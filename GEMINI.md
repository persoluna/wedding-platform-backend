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

---

# What's new in Filament v4? - Feature Overview

Filament v4 is a major update with a focus on performance, developer experience, and user interface enhancements.

## Highlights

*   **Improved Performance:** Server rendering time for large tables is reduced by 2-3x.
*   **Tailwind CSS v4:** The framework now uses Tailwind CSS v4, bringing a new configuration system, improved customization, and faster builds.
*   **Built-in Multi-Factor Authentication (MFA):** Support for TOTP apps (Google Authenticator, Authy) and email-based one-time codes.
*   **Nested Resources:** Resources can be nested to reflect their hierarchy in breadcrumbs and URLs.
*   **New Form Fields:**
    *   **Tiptap Rich Editor:** With support for custom blocks, merge tags, and temporary private image URLs.
    *   **Slider:** For selecting numeric values.
    *   **Code Editor:** For writing and editing code.
    *   **Table Repeater:** To display repeater items in a table layout.
*   **Tools to Reduce Network Requests:**
    *   `hiddenJs()` and `afterStateUpdatedJs()` to control field visibility and state updates using JavaScript.
    *   Partial rendering to re-render only specific components.
*   **Tables with Custom Data:** Tables can now be backed by custom data sources, not just Eloquent models.
*   **Improved Bulk Action System:**
    *   Authorize individual records in bulk actions.
    *   Notifications for bulk action results with success and failure counts.
    *   Improved performance through chunked processing.
*   **Restructured Documentation:** Clearer overview of features with more examples and cross-references.

## General

*   **Improved Performance:** Optimized Blade templates, reduced view rendering, and smaller HTML output.
*   **Tailwind CSS v4:** Uses `oklch` for more vivid and accurate colors in the P3 color gamut.
*   **Semantic Headings and Dynamic Color Systems:**
    *   Dynamically generated heading levels for proper semantic HTML structure.
    *   More accessible contrast ratios with dynamically calculated text colors.

## Authentication

*   **Multi-Factor Authentication (MFA):** Built-in support for app-based and email-based MFA.
*   **Icon Enums:** The new `Heroicon` enum provides IDE autocompletion for icons.
*   **Default Timezone:** The `FilamentTimezone` facade allows setting a global default timezone.
*   **"ISO" Date-Time Formats:** Support for standard "ISO" formats in `TextColumn` and `TextEntry`.

## Resources

*   **Nested Resources:** Create and manage complex related records with their own resources.
*   **Better Resource Class Organization:** Resource classes are now generated in dedicated namespaces.
*   **Code Quality Tips:** New documentation on keeping Filament code clean and maintainable.
*   **Preserving Data When Creating Another Resource Record:** The `preserveFormDataWhenCreatingAnother()` method allows retaining form data.
*   **More Easily Customize Page Content:** The `content()` method allows full control over page layouts.
*   **Globally Customizing Resource Redirects:** Configure the default redirect behavior after creating a resource.
*   **Disabling Global Search Term Splitting:** The `$shouldSplitGlobalSearchTerms` property improves search performance.

## Relation Managers

*   **Customizing the Content Tab:** The `getContentTabComponent()` method allows full customization of the main content tab.

## Navigation

*   **Sidebar / Topbar Livewire Reactivity:** The Sidebar and Topbar are now Livewire components that can be updated dynamically.

## Schemas

*   **Vertical Tabs:** Switch to a vertical tab layout using the `vertical()` method.
*   **Container Queries:** Create responsive layouts based on the size of a parent container.

## Forms

*   **New Rich Editor:** Now using Tiptap, a modern and extensible open-source editor.
*   **Storing Content as HTML or JSON:** The rich editor can store content as HTML or JSON.
*   **Custom Blocks:** Define custom blocks that users can drag and drop into the rich editor.
*   **Merge Tags:** Insert placeholders like `{{ name }}` into rich content.
*   **Extending the Rich Editor:** Create custom plugins to add new extensions, buttons, and rendering behavior.
*   **Slider:** A new component for selecting numeric values.
*   **Code Editor:** A new component for writing and editing code.
*   **Table Repeater:** Display repeater items in a table layout.
*   **Selecting Options from a Table in a Modal:** The `ModalTableSelect` component allows selecting records from a modal.
*   **Using JavaScript to Minimize Network Requests:**
    *   `hiddenJs()` and `visibleJs()` for client-side visibility toggling.
    *   `JsContent` for dynamically setting text content with JavaScript.
    *   `afterStateUpdatedJs()` to run JavaScript expressions when a field value changes.
*   **Fusing Fields into a Group:** The `FusedGroup` component visually combines multiple fields.
*   **Adding Extra Content to a Field:** New slots for adding content around fields.
*   **Partial Rendering:** More efficient options for re-rendering only specific parts of the schema.
*   **Improved Type Casting:** Form field state is now automatically cast to the correct data type.

## Infolists

*   **Code Entry:** A new entry for displaying highlighted code snippets.

## Tables

*   **Tables with Custom Data:** Use custom data sources for tables, including arrays and external APIs.
*   **Empty Relationships with Select Filters:** The `hasEmptyOption()` method allows filtering for records without a related model.
*   **Column Headers Now Visible on Empty Tables:** Table headers are now shown even when no records are present.
*   **Reorderable Table Columns:** Users can now drag and rearrange visible columns.

## Actions

*   **Unified Actions:** A single `Filament\Actions` namespace for all actions.
*   **Toolbar Actions:** A dedicated area for actions in the table toolbar.

## Bulk Actions

*   **Improving Bulk Action Performance:** The `chunkSelectedRecords()` method processes records in smaller batches.
*   **Authorizing Bulk Actions:** The `authorizeIndividualRecords()` method checks a policy for each selected record.
*   **Bulk Action Notifications:** Display notifications with success and failure counts.
*   **Prebuilt Bulk Actions:** Improved performance for prebuilt bulk actions.
*   **Deselected Records:** Deselected records are now tracked when using "Select all".
*   **Rate Limiting Actions:** The `rateLimit()` method limits how often an action can be triggered.
*   **Authorization:** Authorization messages can now be shown in action tooltips and notifications.

## Import/Export

*   **Importing Relationships:** `BelongsToMany` relationships can now be imported.
*   **Styling XLSX Columns:** Customize the styling of individual cells in XLSX exports.
*   **Customizing the XLSX Writer:** Configure the OpenSpout XLSX writer.

## Other

*   **Tooltips for Disabled Buttons:** Display tooltips on disabled buttons.
*   **Testing Actions:** Simplified and more streamlined action testing.
*   **Collapsible Chart Widgets:** Charts can now be made collapsible.
*   **Custom Filters for Chart Widgets:** Chart widgets now support custom filter schemas.
*   **Dashboard:** Dashboard widgets now support the full responsive grid layout system.
*   **Multi-Tenancy:**
    *   Global scopes and lifecycle events are now applied automatically.
    *   `scopedUnique()` and `scopedExists()` validation rules for proper data isolation.
*   **Panel Configuration:**
    *   The Inter font is now loaded locally by default.
    *   The sub-navigation position can be configured globally.
    *   Strict authorization mode to enforce explicit policies.
    *   Email change verification.
    *   Customizable error notifications.
