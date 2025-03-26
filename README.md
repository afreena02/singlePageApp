# Laravel 12 Setup Guide with Laragon

## Clone the Repository
1. Open Laragon Terminal and navigate to the `www` directory:
   ```sh
   cd C:\laragon\www
   ```
2. Clone the repository:
   ```sh
   git clone https://github.com/afreena02/singlePageApp.git
   ```
3. Navigate to the project directory:
   ```sh
   cd singlePageApp
   ```

## Install Laravel Dependencies
Run the following command to install the required dependencies:
```sh
composer install
```

**Note:** We are using the same database as **UserApplication**.

## Configure the `.env` File
1. Copy the `.env.example` file to `.env`:
   ```sh
   cp .env.example .env
   ```
2. Edit the `.env` file with the following database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=website_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```

## Generate the Application Key
Run the following command:
```sh
php artisan key:generate
```
This will update the `APP_KEY` in your `.env` file.

## Create Storage Link
Run the following command to link the storage folder:
```sh
php artisan storage:link
```

## Optimize the Application
Run the following command to optimize performance:
```sh
php artisan optimize
```

## Serve the Application
Use the Laravel built-in server to run the application:
```sh
php artisan serve
```
The application will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Troubleshooting
### Laragon Not Starting
- Ensure required ports (**80 for Apache**, **3306 for MySQL**) are not being used by other applications.

### Composer Issues
If you encounter dependency issues, try:
```sh
composer update
composer install
composer clear-cache
```

## Conclusion
You've successfully set up Laravel 12 on your local machine using Laragon. You can now start building and testing your application!

---

## .env File Configuration

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:By6WQ0rrJCP0X4K8eoYwk0KP6GGhm81DVmDeAW8vO2Q=
APP_DEBUG=true
APP_URL=http://localhost:8000
BASE_URL=http://userapplication.test

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_test
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

