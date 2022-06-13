<?php

use Amirabbas8643\Todo\Http\Controllers\LabelController;
use Amirabbas8643\Todo\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web']], function ()
{
    Route::resource('task' , TaskController::class);
    Route::resource('label' , LabelController::class);
});
