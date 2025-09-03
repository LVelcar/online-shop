<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| This file is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', [MainController::class, 'index'])->name('main');

Route::resource('products', ProductController::class);
Route::resource('products.carts', ProductCartController::class)->only(['store', 'destroy']);
Route::resource('carts', CartController::class)->only(['index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
