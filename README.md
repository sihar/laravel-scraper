# Scraping Portfolio Application

## Stack
- Laravel 12
- PostgreSQL

## Setup
```
git clone https://github.com/sihar/laravel-scraper.git
cd laravel-scraper
composer install
```

Copy .env.example to .env and adjust DB credentials

```
php artisan migrate:fresh
php artisan serve
```

Generate dummy data (optional)
```
php artisan db:seed --class=TalentProfileSeeder
```

Generate API documentation
```
php artisan l5-swagger:generate
```

Open url API documentation
```
http://[your_domain]/api/documentation
```

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
