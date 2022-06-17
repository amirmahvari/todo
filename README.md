# Todo list package for laravel

This package for create todo list with unique labels

Install Documentation

Min laravel version is 7.*

Make directory in your laravel project ,open your command line.
```bash
mkdir packages/amirmahvari
cd packages/amirmahvari
git clone https://github.com/amirmahvari/todo.git
```


### Autoloading

By default, the module classes are not loaded automatically. You can autoload your modules using `psr-4`. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Amirmahvari\\Todo\\": "packages/amirmahvari/todo/src"
  }
}
```


Append Todo  service provider to `providers` array in `config/app.php`.
```php
'providers' => [
        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        ...
        Amirmahvari\Todo\TodoServiceProvider::class,
        ...
],
```

update your composer
```bash
composer dumpautoload
```


publish package
```bash
php artisan vendor:publish --provider="Amirmahvari\Todo\TodoServiceProvider"
```


migrate the migrations.
```shell
php artisan migrate
```

the routes list is /task and /label .


## Testing

``` bash
$ phpunit
```
