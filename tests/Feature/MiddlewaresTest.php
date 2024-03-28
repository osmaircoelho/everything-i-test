<?php

use App\Models\User;
use function Pest\Laravel\{get, mock, actingAs};

it('should block a request if the user does not have the following email: osmair.coelho@gmail.com', function (){

    $user = User::factory()->create(['email' => 'email@any.com']);

    $osmair = User::factory()->create(['email' => 'osmair.coelho@gmail.com']);

    actingAs($user);
    get(route('secure-route'))->assertForbidden();

    actingAs($osmair);
    get(route('secure-route'))->assertOk();
});

test('check if is being called', function (){

    mock(\App\Http\Middleware\SecureRouteMiddleware::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    get(route('secure-route'));
});
