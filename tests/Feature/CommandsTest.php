<?php

use App\Console\Commands\ExportProductToAmazon;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to create a product via command', function (){
   $user = User::factory()->create();

   artisan(
       ExportProductToAmazon::class,
    ['title' => 'Product 1', 'user' => $user->id]
   )
       ->assertSuccessful();

   assertDatabaseHas('products', ['title' => 'product 1', 'owner_id' => $user->id]);
   assertDatabaseCount('products', 1);
});

it('should asks for user and title if is not passed as arguments', function () {

    $user = User::factory()->create();

    artisan(ExportProductToAmazon::class, [])

        ->expectsQuestion('Please, provide a valid user id ', $user->id)

        ->expectsQuestion('Please, provide a title for the product ', 'Product 1')

        ->expectsOutputToContain('Product created!!')

        ->assertSuccessful()
        ;
});


