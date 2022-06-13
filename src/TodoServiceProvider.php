<?php
namespace Amirabbas8643\Todo;

use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->publishes([
            realpath(__DIR__ . '/migrations') => database_path('migrations') ,
        ] , 'migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views' , 'Todo');
        $this->publishes([
            realpath(__DIR__ . '/views') => base_path('resources/views/Amirabbas8643/Todo') ,
        ]);
    }
}
