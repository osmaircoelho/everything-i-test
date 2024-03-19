<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function (){
    return ['oi'];
});

Route::get('/403', function (){

    abort_if(true, 403);

    return ['oi'];
});

Route::get('/products', function (){
    return view('products', [
         'products' =>    \App\Models\Product::all()
    ]);
});

