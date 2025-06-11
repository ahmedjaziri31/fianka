# 🚀 FIANKA Quick Setup Guide

## One-Command Setup (Windows with XAMPP)

1. **Start XAMPP** (Apache + MySQL)

2. **Run these commands in order:**
   ```bash
   # Install dependencies
   composer install
   
   # Create database
   php bin/console doctrine:database:create
   
   # Import database structure
   # Go to http://localhost/phpmyadmin and import: fianka_database_phpmyadmin.sql
   
   # Sync migrations
   php bin/console doctrine:migrations:sync-metadata-storage
   
   # Start server
   symfony serve --port=8000
   ```

3. **Visit:** http://127.0.0.1:8000

## Environment Setup

Create `.env.local` file:
```bash
APP_ENV=dev
DATABASE_URL=mysql://root:@127.0.0.1:3306/fianka
MAILER_DSN=smtp://localhost:1025
```

## Troubleshooting

**Port 8000 busy?**
```bash
symfony serve --port=8001
```

**Database issues?**
```bash
php bin/console doctrine:migrations:sync-metadata-storage
php bin/console cache:clear
```

**Assets not loading?**
- Check `public/build/app.css` exists
- Check `public/build/app.js` exists

## Done! 🎉

Your FIANKA e-commerce platform is ready! 