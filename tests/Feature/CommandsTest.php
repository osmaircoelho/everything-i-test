<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('should be able to create a product via command', function (){
   $user = User::factory()->create();

   artisan(
       CreateProductCommand::class,
    ['title' => 'Product 1', 'user' => $user->id]
   )
       ->assertSuccessful();

   assertDatabaseHas('products', ['title' => 'product 1', 'owner_id' => $user->id]);
   assertDatabaseCount('products', 1);
});
