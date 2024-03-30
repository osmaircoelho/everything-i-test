<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {

    $products = Product::get(['title'])->toArray();

    //$products->map(fn($p) => ['title' => $p->title] );

    return array_merge([
        ['title' => 'Product A'],
        ['title' => 'Product B'],
    ], $products);
});
