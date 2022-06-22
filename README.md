### Installation 

#### Vue App

Go to the vue-app folder and run
```shell
cd {ROOT}
cd ./vue-app
yarn
```

```
yarn run build-app 
```
> the watch command will build the files and copy them to the laravel application

#### Laravel App

Go to laravel app and run 
```shell
cd {ROOT}
cd ./laravel-app
composer install
```

```shell
php artisan migrate
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

#### Schedule jobs

Run command to set up the scheduled jobs (normally this would be set to run on cron)
```shell
php artisan schedule:run
```

run the report generation manually with following command
```shell
php artisan currency:collect
```

### Viewing the application
```shell
php artisan serve
```

1. Go to url (depending on port)  eg. [http://127.0.0.1:8000/register](http://127.0.0.1:8000/register)  
2.Register a user, then login - [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
 





