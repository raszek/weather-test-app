# Setup application

```bash
cp .env.example .env
```

Add key
```
OPEN_WEATHER_TOKEN=
```
from
https://openweathermap.org/

Add key
```
WEATHER_TOKEN=
```
from
https://www.weatherapi.com/

Setup database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Install packages
```bash
composer install
```

# Running tests

php artisan test
