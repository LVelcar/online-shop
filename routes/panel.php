<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\PanelController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
| 
*/


Route::get('/', [PanelController::class, 'index'])->name('panel');
Route::resource('products', ProductController::class);

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::post('users/admin/{user}', [UserController::class, 'toggleAdmin'])->name('users.admin.toggle');
