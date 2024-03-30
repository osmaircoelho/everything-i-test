<?php

use App\Console\Commands\{ExportProductToAmazon, ImportFromAmazonCommand};
use App\Models\{Product, User};
use Illuminate\Http\Client\Request;

use function Pest\Laravel\{artisan, assertDatabaseCount, assertDatabaseHas};

it('should fake an api request', function () {
    User::factory()->create();

    Http::fake([
        'https://api.amazon.com/products' => Http::response([
            ['title' => 'Product 1'],
            ['title' => 'Product 2'],
        ]),
    ]);

    artisan(ImportFromAmazonCommand::class)
        ->assertSuccessful();

    assertDatabaseHas('products', ['title' => 'Product 1']);
    assertDatabaseHas('products', ['title' => 'Product 2']);
    assertDatabaseCount('products', 2);
});

test('testing the data that we send to amazon', function () {
    Http::fake();

    Product::factory()->count(2)->create();

    (new ExportProductToAmazon())->handle();

    Http::assertSent(function (Request $request) {
        return $request->url() == 'https://api.amazon.com/products'
            && $request->header('Authorization') == ['Bearer 123']
            && $request->data() == Product::all()->map(fn ($p) => ['title' => $p->title])->toArray();
    });
});
