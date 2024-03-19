<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return ['oi'];
});

Route::get('/403', function () {

    abort_if(true, 403);

    return ['oi'];
});

Route::get('/products', function () {
    return view('products', [
        'products' => Product::all()
    ]);
});


Route::post('/products', function () {
    Product::query()
        ->create(request()->only('title'));

    return response()->json('', 201);
})->name('product.store');