# Wedplanify Platform - Comprehensive Architecture & History

## 1. Project Overview & Identity
**Wedplanify** is a luxury wedding marketplace platform connecting clients (engaged couples) with service providers (Agencies and Vendors) in the Indian market.
It acts as a centralized management portal handling inquiries, bookings, pricing (in INR), and portfolios.

### Tech Stack
- **Backend Framework:** Laravel 12 (PHP 8.3)
- **Database:** PostgreSQL (via Laravel Sail/Docker)
- **Admin/Provider Panels:** Filament v4 (Multi-tenant panels: `/admin`, `/agency`, `/vendor`)
- **Frontend / Fullstack:** Blade Templates + Livewire 3
- **Media Management:** Spatie Laravel Media Library
- **Authentication:** Filament Shield (Roles/Permissions) for providers, native auth for clients.
- **Search:** Gemini AI Semantic Search integrated with Livewire.

## 2. Historical & Development Context (Commits & Evolution)
- **Iterative Schema:** Began in late 2025 and matured through early 2026. Includes polymorphic setups (Reviews, Bookings, FAQs, Packages) to attach to both Agencies and Vendors.
- **Recent Additions:** Database push notifications implemented for the Filament UX (`notifications` table added, `data` column upgraded to JSON/JSONB for Postgres compatibility).
- **Security Emphasis:** Introduced hard boundaries via Policies and Filament hooks to ensure users only access their own data. Super Admin override explicitly configured via `Gate::before`.
- **Pre-Onboarding Flow:** Registration for vendors uses a `ProfessionalApplication` pipeline (via `/join` Livewire component) to gatekeep the provider quality before converting them into actual Users.

## 3. Core Business Logic & Flows
- **Strict User Segmentation (`type` column):** 4 user types (`admin`, `agency`, `vendor`, `client`).
- **Inquiry Protection:** Prevents duplicate spam by checking for active inquiries between a client-vendor pair before allowing new messages.
- **Booking Pipeline:** Manages complex payment phases (`deposit_amount` vs `balance_amount`) and tracks lifecycle (deposit paid -> fully paid) to prevent booking collision.
- **Agency/Vendor Relationship:** Agencies act as umbrellas, owning and managing multiple vendors via a many-to-many pivot (`agency_vendor_table`).
- **Soft Deletes Everywhere:** Prevent breaking relational data like past invoices, inquiries, or chat history when users leave the platform. Checks implemented in tables to hide force-delete buttons.

## 4. System Architecture
### Polymorphism & Data Coupling
Packages, FAQs, Portfolio Images, and Bookings use `@morphTo` relationships because they can belong to *either* an Agency *or* a Vendor.
### Frontend (Livewire)
- The Explore page (`/explore`) is aggressively reactive. URL binds (`#[Url]`) ensure the state is fully sharable and SEO friendly.
- Integrates `localStorage` to save user "favorites" passively before requiring account creation.
### Asset Handling (Spatie)
- Unified `media` table.
- Forces single-file restrictions on `logo`/`banner` collections to save space, while allowing multiple files for `gallery`/`portfolio`.

## 5. API Layer
- **Read-Only API (v1):** `api/v1/agencies` and `api/v1/vendors` configured for future decoupled headless frontends. Includes aggressive rate limiting (`throttle:120,1`).
- **Output:** Uses Eloquent API Resources to map complex relations into flat, consumable JSON containing nested properties (stats, social, media URLs).

## 6. Infrastructure & Deployment
- Relies heavily on **Laravel Sail** (Docker).
- Services: `pgsql`, `redis`, `mailpit` (for development email testing).
- Recommend WSL2 for Windows users for optimal file IO performance with Docker.
