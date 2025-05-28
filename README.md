<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Laravel VPN Management App

This project is a Laravel-based VPN management application that allows users to connect to VPN servers, manage their VPN configurations, and track their VPN connections.

## Features

- User authentication and authorization
- VPN server management
- VPN configuration management
- User VPN connection tracking
- Modern, responsive UI

## Requirements

- PHP 8.1 or higher
- Composer
- SQLite (for local development) or MySQL (for production)
- OpenVPN (for VPN functionality)

## Local Development Setup

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd vpn
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure the database:
   - For SQLite (local development):
     ```bash
     touch database/database.sqlite
     ```
     Update `.env`:
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database.sqlite
     ```
   - For MySQL:
     Update `.env` with your MySQL credentials.

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

7. Visit `http://localhost:8000` in your browser.

## Production Deployment on Digital Ocean

### 1. Prepare Your Server

Update and install dependencies:
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install nginx git unzip curl php php-fpm php-mbstring php-xml php-zip php-curl php-gd php-sqlite3 composer -y
```

### 2. Upload Your Laravel Project

Clone your project:
```bash
cd /var/www
sudo git clone <your-repo-url> vpn
cd vpn
```

Install dependencies:
```bash
sudo composer install --no-dev --optimize-autoloader
```

Set permissions:
```bash
sudo chown -R www-data:www-data /var/www/vpn
sudo chmod -R 775 storage bootstrap/cache
```

### 3. Configure Environment

Copy and edit your environment file:
```bash
cp .env.example .env
nano .env
```

Set `APP_KEY` (generate with `php artisan key:generate`), `APP_URL`, and database settings.

### 4. Set Up Database

For SQLite:
```bash
touch database/database.sqlite
sudo chown www-data:www-data database/database.sqlite
```

Update `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/vpn/database/database.sqlite
```

For MySQL, create a database and user, then update `.env` accordingly.

Run migrations and seeders:
```bash
php artisan migrate --seed
```

### 5. Configure Nginx

Create a new Nginx config:
```bash
sudo nano /etc/nginx/sites-available/vpn
```

Paste:
```nginx
server {
    listen 80;
    server_name your-domain.com; # or your server IP

    root /var/www/vpn/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable the site and restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/vpn /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 6. Set Up SSL (Optional)

Use Let's Encrypt:
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d your-domain.com
```

### 7. Run Laravel Scheduler and Queue (if needed)

Add to your crontab:
```bash
* * * * * cd /var/www/vpn && php artisan schedule:run >> /dev/null 2>&1
```

### 8. Visit Your App

Go to `http://your-domain.com` or your server's IP in your browser.

### 9. OpenVPN Integration

To provide VPN service, install and configure OpenVPN:
```bash
sudo apt install openvpn easy-rsa
```

Set up server and client configs, and integrate certificate/key management with your Laravel app (see the `OpenVpnService` class for where to add this logic).

### 10. Security

- Set strong passwords for all users.
- Use HTTPS.
- Keep your server updated.
- Restrict SSH access.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# opensource-vpn
