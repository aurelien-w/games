# Game leaderboard

This is a Laravel port of the original repository. It has been enhanced a little bit 😉 

#### Installation
```shell
# Clone the project
git clone -b laravel --single-branch https://github.com/NicolasMica/games.git
cd games
 
# Copy and fill the config file
# Unix
cp .env.example .env
# Windows
copy .env.example .env
 
# Install PHP dependencies
composer install
 
# Generates app keys
php artisan key:generate
 
# Install NPM dependencies
npm install
 
# Run the server
php artisan serve
```
#### Assets
```shell
# Development build
npm run dev
 
# Watch/Hot reload
npm run watch / hot
 
# Production build
npm run production
```

#### Production
Theses commands and config are required to properly set Laravel in production mode
```shell
# Set app in production (update .env)
APP_ENV=production
APP_DEBUG=false
APP_LOG_LEVEL=error
 
# Caches routes: only if not using route closure
php artisan route:cache
 
# Caches configurations: only if using config() in the app not env()
php artisan config:cache
```

#### Built with:
- [Laravel](https://laravel.com)
- [Bulma](https://bulma.io)
- [VueJs](https://vuejs.org)

