<?php
namespace Amirabbas8643\Todo;

use Illuminate\Support\Facades\Route;
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
        // Controllers
        $this->app->make('Amirabbas8643\Todo\Http\Controllers\TaskController');
        $this->app->make('Amirabbas8643\Todo\Http\Controllers\LabelController');

        //Requests
        $this->app->make('Amirabbas8643\Todo\Http\Requests\Task\TaskStoreRequest');
        $this->app->make('Amirabbas8643\Todo\Http\Requests\Task\TaskUpdateRequest');
        $this->app->make('Amirabbas8643\Todo\Http\Requests\Label\LabelUpdateRequest');
        $this->app->make('Amirabbas8643\Todo\Http\Requests\Label\LabelStoreRequest');

        // Models
        $this->app->make('Amirabbas8643\Todo\Models\Task');
        $this->app->make('Amirabbas8643\Todo\Models\Label');

        // Services
        $this->app->make('Amirabbas8643\Todo\Service\TaskService');
        $this->app->make('Amirabbas8643\Todo\Service\LabelService');
        Route::group([
            'middleware' => ['bindings','web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/views') => base_path('resources/views/Amirabbas8643/Todo') ,
            realpath(__DIR__ . '/Database/migrations') => database_path('migrations') ,
        ]);

        $this->loadViewsFrom(__DIR__ . '/views' , 'Todo');
        $this->loadFactoriesFrom(__DIR__ . '/Database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
