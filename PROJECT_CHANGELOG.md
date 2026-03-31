# Wedplanify Platform - The First 41 Commits (Detailed Timeline & Changes)

This document tracks the exact architectural steps and feature implementations introduced throughout the project's foundational phase. It traces the platform from its raw Laravel 12 scaffolding up to a fully realized multitenant Indian wedding marketplace with AI Search and real-time reactive filters.

## Phase 1: The Scaffolding & Multitenant Skeleton (Commits 1-7)
- **Initial Setup:** Blank Laravel 12 project with Sail and Filament 4 scaffolding.
- **Roles & Permissions:** Integrated `Spatie Permission` and `Filament Shield` for deep resource gatekeeping.
- **The Three Pillars (Panels):** Scaffolded `/admin`, `/agency`, and `/vendor` portals.
- **Agency & Vendor Scoping:** Set up strict Eloquent query scopes on panels ensuring vendors can only see their own inquiries, and agencies can only see the inquiries of the vendors they "own."

## Phase 2: Data Architecture & Media Management (Commits 8-15)
- **Spatie Media Library:** Added `media` table migration. Refactored agency/vendor forms to strictly use polymorphic file uploads (`logo`, `banner`, `gallery`).
- **Safety Nets (UX):** Implemented secure delete actions globally that natively warn or block `Admins` from hard-deleting records that have relational dependencies.
- **REST API Scaffolding:** Began exposing read-only `api/v1/agencies` and `api/v1/vendors` endpoints with dynamic URL and relational expansion parameters.
- **Aesthetic Core:** Applied `Plus Jakarta Sans` typography and unified Filament themes across all three panels. 

## Phase 3: The Reality Check (Testing & Demo Environments) (Commits 16-24)
- **Factories & Tests:** Added comprehensive unit tests and factories for every core model (Agency, Vendor, Bookings, Clients, etc.).
- **Data Hydration:** Built massive `DemoUserSeeder` ensuring consistent dummy data generation for manual QA. Included robust Spatie role assignment in the seeder.
- **Rupee Globalization:** A massive system-wide find-and-replace upgrading the default currency from USD ($) to INR (₹) across dashboards, form schemas, and table columns.
- **Storage Fixes:** Added public storage links/bypasses for Docker/Nginx compatibility.

## Phase 4: Public Frontend Initialization (Commits 25-32)
- **End-User Onboarding:** Built a dynamic client registration and login portal.
- **Saved Listings (LocalStorage):** Engineered the core UX flow where unauthenticated users can click a "Heart" icon to save a listing, which persists in Javascript `localStorage` until they officially create an account.
- **Explore Listings:** Initialized the first iteration of the unified agency/vendor frontend rendering engine (`App\Livewire\ExploreListings`), marrying the backend REST API logic onto Livewire reactive state.
- **The Booking Pipeline (v1):** Structured the public calendar UX for vendors, enabling a literal visual booking pipeline.

## Phase 5: The "Luxury" UX Polish & AI (Commits 33-41)
- **Spam Interception:** Engineered the absolute inquiry interception logic. The system now natively blocks clients from submitting multiple new inquiries to the same vendor if an unresolved one exists.
- **Livewire Pagination & Reactive Routing:** Converted all search parameters (`min_price`, `max_price`, `category`) to continuous reactive filters reflecting immediately in the browser URL (`#[Url]`).
- **Event-Driven Database Notifications:** Added push notifications natively triggering when an inquiry status changes (e.g., New -> Responded), popping up directly into the specific vendor/agency's active Filament window.
- **New Landing Pages:** Designed custom glassmorphic headers and Footers for a "Premium" Indian aesthetic.
- **Gemini AI Search:** Engineered the AI search modal overriding basic keyword searches using Google's Gemini to parse semantic intent (e.g., "cheap florists near me").
- **The Pre-Account Workflow:** Hardened the `/join` registry flow. Fixed category relational errors upon Admin approval, guaranteeing the translation from an "Application" into a strict "Vendor" user role without throwing `UnitEnum` strict type errors in PHP 8.4.
- **The Super Admin Key:** Discovered and terminated permission bleeding by implementing a hard `Gate::before` intercept, guaranteeing Super Admins bypass all localized role restrictions perfectly. 
