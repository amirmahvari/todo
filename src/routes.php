<?php

use Amirmahvari\Todo\Http\Controllers\Api\LabelController;
use Amirmahvari\Todo\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'todo' ,
    'middleware' => 'auth' ,
] , function()
{
    Route::prefix('task')
        ->name('task.')
        ->group(function()
        {
            Route::get('' , [TaskController::class , 'index'])
                ->name('index');
            Route::get('{task}' , [TaskController::class , 'show'])
                ->name('show');
            Route::post('' , [TaskController::class , 'store'])
                ->name('store');
            Route::post('{task}/status' , [TaskController::class , 'status'])
                ->name('status');
            Route::patch('{task}' , [TaskController::class , 'update'])
                ->name('update');
            Route::delete('destroy/{task}' , [TaskController::class , 'destroy'])
                ->name('destroy');
        });
    Route::prefix('label')
        ->name('label.')
        ->group(function()
        {
            Route::get('' , [LabelController::class , 'index'])
                ->name('index');
            Route::get('{label}' , [LabelController::class , 'show'])
                ->name('show');
            Route::post('' , [LabelController::class , 'store'])
                ->name('store');
            Route::patch('{label}' , [LabelController::class , 'update'])
                ->name('update');
            Route::delete('destroy/{label}' , [LabelController::class , 'destroy'])
                ->name('destroy');
        });
});
