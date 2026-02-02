<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public pages
Route::get('/', function () {
    return Inertia::render('Public/ProductsIndex');
});
Route::get('/product/{id}', function ($id) {
    return Inertia::render('Public/ProductShow', ['id' => $id]);
});
Route::get('/cart', function () {
    return Inertia::render('Public/Cart');
});
Route::get('/favorites', function () {
    return Inertia::render('Public/Favorites');
});

// Auth / Admin pages
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});

Route::get('/admin/products', function () {
    return Inertia::render('Admin/ProductsIndex');
});

Route::get('/admin/products/create', function () {
    return Inertia::render('Admin/ProductForm');
});

Route::get('/admin/products/{id}/edit', function ($id) {
    return Inertia::render('Admin/ProductForm', ['id' => $id]);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// The default welcome route was removed so the Inertia route defined above
// `Route::get('/', fn() => Inertia::render('Public/ProductsIndex'))` will be used.
