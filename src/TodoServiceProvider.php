<?php

namespace Amirabbas8643\Todo;

use Illuminate\Http\Resources\Json\JsonResource;
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
        //Routes
        Route::prefix('api')
            ->middleware(['bindings' , 'api' , 'token'])
            ->group(function()
            {
                $this->loadRoutesFrom(__DIR__ . '/routes.php');
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        $this->publishes([
            realpath(__DIR__ . '/views')               => base_path('resources/views/Amirabbas8643/Todo') ,
            realpath(__DIR__ . '/Database/migrations') => database_path('migrations') ,
        ]);
        $this->loadViewsFrom(__DIR__ . '/views' , 'Todo');
        $this->loadFactoriesFrom(__DIR__ . '/Database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
