# 🛍️ FIANKA - Fashion E-commerce Platform

A modern, elegant e-commerce platform built with Symfony 7.2 for fashion retail.

## ✨ Features

- 🎨 **Beautiful Design** - Custom color palette with cream, gold, and teal themes
- 👤 **User Authentication** - Registration, login, password reset
- 🛒 **Shopping Cart** - Add products, manage quantities
- 📦 **Order Management** - Complete order processing
- 🌐 **Multi-language** - French and English support
- 📧 **Newsletter** - Email subscription system
- 📱 **Responsive** - Mobile-friendly design
- 🔒 **Secure** - Built with Symfony security best practices

## 🚀 Quick Start

### Prerequisites

- **PHP 8.2+** 
- **Composer** 
- **MySQL/MariaDB**
- **XAMPP** (recommended for local development)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/fianka.git
   cd fianka
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env .env.local
   ```
   Edit `.env.local` and configure your database:
   ```
   DATABASE_URL=mysql://root:@127.0.0.1:3306/fianka
   ```

4. **Start XAMPP**
   - Start Apache and MySQL services
   - Open phpMyAdmin (http://localhost/phpmyadmin)

5. **Create database**
   ```bash
   php bin/console doctrine:database:create
   ```

6. **Import database** (choose one option):
   
   **Option A: Via phpMyAdmin**
   - Import `fianka_database_phpmyadmin.sql`
   
   **Option B: Via command line**
   ```bash
   mysql -u root -p fianka < fianka_database_setup.sql
   ```

7. **Run migrations**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

8. **Start the server**
   ```bash
   symfony serve --port=8000
   ```
   Or with PHP built-in server:
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

9. **Visit your app**
   Open http://127.0.0.1:8000 in your browser

## 🛠️ Development

### Project Structure
```
fianka/
├── src/                 # PHP source code
│   ├── Controller/      # Symfony controllers
│   ├── Entity/         # Database entities
│   ├── Form/           # Form types
│   └── Repository/     # Database repositories
├── templates/          # Twig templates
├── public/            # Web assets
│   ├── build/         # CSS/JS files
│   └── images/        # Static images
├── assets/            # Source assets
├── config/            # Configuration files
└── migrations/        # Database migrations
```

### Key Commands

```bash
# Clear cache
php bin/console cache:clear

# Create new controller
php bin/console make:controller

# Create new entity
php bin/console make:entity

# Generate migration
php bin/console make:migration

# Run migrations
php bin/console doctrine:migrations:migrate

# Load fixtures (if available)
php bin/console doctrine:fixtures:load
```

## 🎨 Customization

### Colors
The app uses CSS custom properties defined in `public/build/app.css`:
- `--dune-light`: #FFFAE6 (Light cream)
- `--dune-gold`: #A0825E (Warm gold)
- `--porto`: #15282A (Dark teal)

### Adding Products
1. Access admin panel (if implemented)
2. Or use database directly via phpMyAdmin
3. Add to `product` table with categories

### Email Configuration
Update `.env.local` with your SMTP settings:
```
MAILER_DSN=smtp://username:password@smtp.example.com:587
```

## 🌐 Languages

Switch between French and English using the language selector in the footer.

Translation files are in `translations/`:
- `messages.fr.yaml` - French translations
- `messages.en.yaml` - English translations

## 📧 Newsletter

The newsletter system collects email addresses. Configure email settings to send newsletters.

## 🔧 Troubleshooting

### Common Issues

**Database connection error:**
- Check XAMPP MySQL is running
- Verify database credentials in `.env.local`

**Assets not loading:**
- Ensure `public/build/` directory exists
- Check file permissions

**Symfony server won't start:**
- Try different port: `symfony serve --port=8001`
- Use PHP built-in server instead

**Migration errors:**
- Run: `php bin/console doctrine:migrations:sync-metadata-storage`
- Clear cache: `php bin/console cache:clear`

## 📝 License

This project is proprietary software for FIANKA fashion brand.

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📞 Support

For support, email contact@fianka-shop.com or create an issue in this repository.

---

**Made with ❤️ for FIANKA Fashion** 
