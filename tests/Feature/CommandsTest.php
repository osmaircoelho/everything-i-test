<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;

use function Pest\Laravel\{artisan, assertDatabaseCount, assertDatabaseHas};

it('should be able to create a product via command', function () {
    $user = User::factory()->create();

    artisan(
        CreateProductCommand::class,
        ['title' => 'Product 1', 'user' => $user->id]
    )->assertSuccessful();

    assertDatabaseHas('products', ['title' => 'product 1', 'owner_id' => $user->id]);
    assertDatabaseCount('products', 1);
});

it('should asks for user and title if is not passed as arguments', function () {

    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])

        ->expectsQuestion('Please, provide a valid user id ', $user->id)

        ->expectsQuestion('Please, provide a title for the product ', 'Product 1')

        ->expectsOutputToContain('Product created!!')

        ->assertSuccessful();
});
