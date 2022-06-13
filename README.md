# Todo list package for laravel

This package for create todo list with unique labels

Install Documentation

Min laravel version is 7.*

Make directory in your laravel project ,open your command line.
```bash
mkdir packages
cd packages
git clone https://github.com/amirabbas8643/todo.git
```


### Autoloading

By default, the module classes are not loaded automatically. You can autoload your modules using `psr-4`. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Amirabbas8643\\Todo\\": "packages/amirabbas8643/todo/src"
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
        Amirabbas8643\Todo\TodoServiceProvider::class,
        ...
],
```

update your composer
```bash
composer dumpautoload
```


migrate your migrations.
```shell
php artisan migrate
```


## Testing

``` bash
$ phpunit
```
