<?php

use Amirabbas8643\Todo\Http\Controllers\Api\LabelController;
use Amirabbas8643\Todo\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'todo' ,
    'middleware' => 'auth',
] , function()
{
    Route::prefix('task')
        ->name('task.')
        ->group(function()
        {
            Route::get('' , [TaskController::class , 'index'])->name('index');
            Route::get('{task}' , [TaskController::class , 'show'])->name('show');
            Route::post('' , [TaskController::class , 'store'])->name('store');
            Route::post('{task}/status' , [TaskController::class , 'status'])->name('status');
            Route::put('{id}' , [TaskController::class , 'update'])->name('update');
            Route::group(['prefix' => '{task}/labels/'] , function()
            {
                Route::post('' , [TaskController::class , 'addLabels']);
                Route::post('assign' , [TaskController::class , 'assignLabels']);
            });
        });
    Route::group(['prefix' => 'labels/'] , function()
    {
        Route::get('' , [LabelController::class , 'index']);
        Route::get('{id}' , [LabelController::class , 'show']);
        Route::post('' , [LabelController::class , 'store']);
    });
});
