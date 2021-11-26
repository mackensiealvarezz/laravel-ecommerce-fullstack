<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Imports\InventoryImport;
use App\Imports\OrdersImport;
use App\Imports\ProductsImport;
use Inertia\Inertia;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Product CRUD
Route::resource('products', ProductController::class)->middleware(['auth', 'verified']);

//Orders
Route::get('orders/breakdown', [OrderController::class, 'breakdown'])->middleware(['auth', 'verified'])->name('orders.breakdown');
//- CRUD
Route::resource('orders', OrderController::class)->middleware(['auth', 'verified']);

//Auth
require __DIR__.'/auth.php';
