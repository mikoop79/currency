### Installation 

#### Laravel App

Go to laravel app and run 
```shell
cd ./laravel-app
composer install
```

```shell
php artisan migrations
php artisan serve
```

Check the APP_KEY variable is not empty.

```
APP_KEY={base64:key}
```
If it is, run 
```
php artisan key:generate
```

#### API KEY
Add your API key from the currency layer API to the .env
```
CURRENCY_API_KEY=XXXX
```


#### Vue App

Go to laravel app and run
```shell
cd {ROOT}
cd ./vue-app
yarn

yarn run watch
```

```shell
php artisan migrations
php artisan serve
```

Check the APP_KEY variable is not empty.

```
APP_KEY={base64:key}
```
If it is, run
```
php artisan key:generate
```

#### API KEY
Add your API key from the currency layer API to the .env
```
CURRENCY_API_KEY=XXXX
```
