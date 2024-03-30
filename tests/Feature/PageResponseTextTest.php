<?php

use App\Models\Product;

use function Pest\Laravel\get;

it('should list products')
    ->get('products')
    ->assertOk()
    ->assertSeeTextInOrder([
        'Produto A',
        'Produto B',
    ]);

it('should list products from database', function () {
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();

    get('products')
        ->assertSuccessful()
        ->assertSeeTextInOrder([
            'Produto A',
            'Produto B',
            $product1->title,
            $product2->title,
        ]);
});
