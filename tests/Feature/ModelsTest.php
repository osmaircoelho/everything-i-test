<?php

use App\Models\{Product, User};
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function () {
    $user    = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    $owner = $product->owner;

    expect($owner)
        ->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should always be str()->title()', function () {

    $product = Product::factory()->create(['title' => 'titulo']);

    expect($product)
        ->title->toBe('Titulo');
});

test('model set mutator :: product code should be encrypted', function () {

    $product = Product::factory()->create(['code' => 'Laravel 11']);

    assertTrue(Hash::isHashed($product->code));
});

test('model scopes :: should bling only released products', function () {
    Product::factory()->count(10)->create(['released' => true]);
    Product::factory()->count(5)->create(['released' => false]);

    expect(Product::query()->released()->get())
         ->toHaveCount(10);
});
