<?php

use App\Jobs\ImportProductsJob;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Mail;
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

    request()->validate([
        'title' => ['required', 'max:255']

    ]);

    Product::query()
        ->create([
            'title' => request()->get('title'),
            'owner_id' => auth()->id()
        ]);

    auth()->user()->notify(
      new NewProductNotification()
    );

    return response()->json('', 201);

})->name('product.store');

Route::put('/products/{product}', function(Product $product){
    $product->title = request()->get('title');
    $product->save();
})->name('product.update');

Route::delete('/product/{product}', function (Product $product){
    $product->forceDelete();
})->name('product.destroy');

Route::delete('/product/{product}/soft-delete', function (Product $product){
    $product->delete();
})->name('product.soft-delete');


Route::post('/import-products', function() {
   $data = request()->get('data');

   ImportProductsJob::dispatch($data, auth()->id());

})->name('product.import');

Route::post('/sending-email/{user}', function (User $user){
    Mail::to($user)->send(new \App\Mail\WelcomeEmail($user));
})->name('sending-email');
