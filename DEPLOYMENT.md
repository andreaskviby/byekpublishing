# Deployment Guide

## Event System Setup Complete

The event management system has been successfully implemented with the following features:

### Features
1. **Admin Event Management** (Filament Admin Panel at `/admin/events`)
   - Fully integrated into the Filament admin panel
   - Create, edit, view, and delete events
   - Set event date, time, location, and capacity (1-6 attendees)
   - View all RSVPs for each event in a relation manager
   - Mark events as active/inactive
   - Filter by active/inactive events
   - Search and sort functionality
   - Real-time capacity tracking with RSVP counts

2. **Public Event Pages**
   - Events displayed on homepage (upcoming events only)
   - Individual event detail pages with RSVP form
   - Shows available spots in real-time

3. **RSVP System**
   - Users can RSVP with name, email, phone, and number of guests
   - Automatic capacity checking
   - Rate limiting to prevent spam (5 submissions per hour per IP)
   - Honeypot spam protection

4. **Email Notifications**
   - Admin receives notification at linda.ettehag@gmail.com for each RSVP
   - Users receive confirmation email with:
     - Event details
     - Information about "Fjärilsskugga" book
     - Link to YouTube channel "We Bought An Adventure in Sicily"

## Mailgun Setup for Production

### What's Been Configured:

1. **Symfony Mailgun Package**
   - Installed via composer: `symfony/mailgun-mailer`

2. **Mail Configuration**
   - Added Mailgun mailer to `config/mail.php`
   - Configured for EU endpoint (api.eu.mailgun.net)

3. **Environment Files**
   - **Local (.env)**: Uses Laravel Herd mail server (smtp on port 2525)
   - **Production (.env.production)**: Configured for Mailgun

### Production Deployment Steps:

1. **Copy the production environment file to the server:**
   ```bash
   # On the server
   cp .env.production .env
   ```

2. **Update production database credentials in .env:**
   ```
   DB_DATABASE=your_production_database
   DB_USERNAME=your_production_user
   DB_PASSWORD=your_production_password
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

4. **Clear and optimize caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. **Test email functionality:**
   - Create a test event via `/admin/events`
   - Submit a test RSVP
   - Verify emails are received

### Mailgun Credentials (Already in .env.production):
- Domain: stafehelp.com
- Endpoint: api.eu.mailgun.net (EU region)
- From Address: byek@stafehelp.com
- From Name: BYEK

### Local Development:
Local development continues to use Laravel Herd's built-in mail server (smtp://127.0.0.1:2525). No changes needed for local development.

## Routes Added:

### Admin Routes (Filament):
- `/admin/events` - List all events
- `/admin/events/create` - Create new event
- `/admin/events/{id}` - View event with RSVPs
- `/admin/events/{id}/edit` - Edit event

### Public Routes:
- `/events/{event}` - Public event detail and RSVP page
- Homepage displays upcoming events section

## Database Tables:

- `events` - Stores event information
- `event_rsvps` - Stores RSVP submissions

## Security Features:

- Rate limiting on RSVP submissions
- Honeypot spam protection
- IP address and user agent logging
- Capacity validation
- Email verification for submissions
