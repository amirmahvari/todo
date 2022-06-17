<?php

namespace Amirmahvari\Todo;

use Amirmahvari\Todo\Models\Task;
use Amirmahvari\Todo\Policies\TaskPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
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

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->config();
        $this->loaded();
        $this->publishes([
            realpath(__DIR__ . '/views')               => base_path('resources/views/Amirmahvari/Todo'),
            realpath(__DIR__ . '/Database/migrations') => database_path('migrations'),
        ]);

    }

    public function config()
    {
        JsonResource::withoutWrapping();
        Gate::policy(Task::class, TaskPolicy::class);
    }

    public function loaded()
    {
        Route::prefix('api')
            ->middleware(['bindings', 'api', 'token'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes.php');
            });
        $this->loadViewsFrom(__DIR__ . '/views', 'Todo');
        $this->loadFactoriesFrom(__DIR__ . '/Database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
