<?php

use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('should sends a notifications about a new product' , function (){

    Notification::fake();

    $user = User::factory()->create();

    actingAs($user);

    postJson(route('product.store'), ['title' => 'Product'])
        ->assertCreated();

    Notification::assertCount(1);
    Notification::assertSentTo([$user], NewProductNotification::class);

});
