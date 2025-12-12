# 🗺️ SaloneHub - Sierra Leone Government Services Portal

**Hackathon-Ready MVP** - Find government services, fees, documents, and representatives in 3 clicks.

## 🚀 Quick Start (Localhost)

### Prerequisites
- XAMPP/WAMP/LAMP (Apache + MySQL + PHP 8.x)
- Modern browser (Chrome, Firefox, Safari)

### Installation Steps

1. **Clone/Copy Project**
   ```bash
   # Place all files in: C:\xampp\htdocs\salonehub\
   # Or: /var/www/html/salonehub/ (Linux)
   ```

2. **Create Database**
   ```bash
   # Start MySQL in XAMPP
   # Open phpMyAdmin: http://localhost/phpmyadmin
   # Import seed.sql (creates database + tables + sample data)
   ```

3. **Configure Database** (if needed)
   ```php
   # Edit config.php if your MySQL credentials differ:
   $db_user = 'root';      // Default XAMPP
   $db_pass = '';          // Default XAMPP (empty)
   $db_name = 'salonehub';
   ```

4. **Start Apache**
   ```bash
   # XAMPP Control Panel → Start Apache + MySQL
   ```

5. **Visit Site**
   ```
   http://localhost/salonehub/index.php
   ```

## 📁 Project Structure

```
salonehub/
├── config.php              # Database connection
├── index.php               # Homepage (hero + featured services)
├── services.php            # Service directory + search
├── representatives.php     # MP/Local Council finder
├── admin/
│   ├── index.php          # Admin login (admin/salonehub2025)
│   ├── services.php       # CRUD dashboard
│   └── logout.php         # Session destroy
├── includes/
│   ├── header.php         # Glass navigation + meta tags
│   └── footer.php         # Footer + scripts
├── assets/
│   ├── css/style.css      # Premium glassmorphism design
│   ├── js/app.js          # AJAX modals + search + filters
│   └── images/            # Icons, hero backgrounds
├── seed.sql               # Database schema + 10 services + 20 reps
├── service-worker.js      # PWA offline support
├── manifest.json          # PWA manifest
└── README.md             # This file
```

## 🎨 Features

### Public Features
- ✅ **3-Click Service Lookup**: Home → Search → Modal Details
- ✅ **Real-Time Search**: Filter by service name, agency, region
- ✅ **AJAX Modals**: No page reloads for service details
- ✅ **Representative Finder**: Filter by district
- ✅ **Mobile-First**: Perfect responsive (320px → desktop)
- ✅ **Dark Glass Theme**: Premium glassmorphism UI

### Admin Features
- ✅ **Secure Login**: Session-based auth (admin/salonehub2025)
- ✅ **CRUD Operations**: Create/Edit/Delete services & representatives
- ✅ **Real-Time Updates**: Changes appear instantly on public pages
- ✅ **Data Validation**: Form validation + error handling

## 🗄️ Database Schema

### Tables
- **services**: name, agency, fee, processing_time, documents, locations, contacts, notes, last_verified, region
- **representatives**: name, role, district, constituency, phone, email
- **agencies**: name, contact, email, website, region, description

### Sample Data
- 10 Government Services (Passport, NIN, Voter Registration, etc.)
- 20 Representatives (MPs + Local Councillors)
- 5 Agencies (ECSL, NCRA, CAC, SLRSA, Immigration)

## 🔐 Admin Access

**URL**: `http://localhost/salonehub/admin/`

**Credentials**:
- Username: `admin`
- Password: `salonehub2025`

## 🎯 User Journey

### Public User (3 Clicks)
1. Visit `index.php` → See hero + featured services
2. Search "passport" → Results filtered instantly
3. Click service card → Modal opens with ALL details (fee, docs, contacts, warnings)

### Admin User
1. Login at `admin/index.php`
2. Dashboard shows all services + representatives
3. Add/Edit/Delete → Changes save instantly
4. View public site → See updates immediately

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3 (Glassmorphism), Vanilla JavaScript (AJAX)
- **Backend**: PHP 8.x (PDO, Sessions)
- **Database**: MySQL 5.7+ / MariaDB
- **Hosting**: Works on localhost + InfinityFree + any PHP hosting

## 🎨 Design System

### Colors
- **Primary**: `#1E3A8A` (Deep Blue)
- **Accent**: `#F59E0B` (Gold)
- **Background**: `linear-gradient(135deg, #0F172A 0%, #1E293B 100%)`
- **Glass**: `rgba(255, 255, 255, 0.1)` with backdrop blur

### Typography
- **Headings**: Poppins (Google Fonts)
- **Body**: Inter (Google Fonts)

### Animations
- Smooth transitions (0.3s cubic-bezier)
- 3D card hover effects
- Modal slide-in animations
- 60fps performance

## 🧪 Testing Checklist

- [ ] Homepage loads with hero + 4 featured services
- [ ] Search "passport" → Shows passport card
- [ ] Click service → Modal opens with details
- [ ] Admin login works → Dashboard loads
- [ ] Add new service → Appears on public page
- [ ] Mobile view (DevTools) → Perfect layout
- [ ] All navigation links work (no 404s)
- [ ] Database queries execute without errors

## 🚀 Deployment (InfinityFree)

1. Upload all files via FTP
2. Create database in InfinityFree panel
3. Import `seed.sql` via phpMyAdmin
4. Update `config.php` with InfinityFree DB credentials
5. Visit your domain → Should work perfectly!

## 📝 Notes

- **Corruption Warnings**: Service notes include "Avoid middlemen" warnings
- **Offline Support**: Service Worker caches pages for offline access
- **SEO Ready**: Meta tags, OpenGraph, Schema.org markup
- **Accessibility**: ARIA labels, keyboard navigation, focus management

## 🐛 Troubleshooting

**404 Errors**:
- Ensure all links are relative (`services.php` not `/services.php`)
- Check Apache mod_rewrite is enabled (if using .htaccess)

**Database Errors**:
- Verify MySQL is running
- Check credentials in `config.php`
- Ensure `salonehub` database exists (import seed.sql)

**Admin Login Fails**:
- Clear browser cookies/session
- Check PHP sessions are enabled
- Verify `admin/index.php` redirects correctly

## 📄 License

Built for hackathon demonstration. Free to use and modify.

---

**Built with ❤️ for Sierra Leone citizens**

