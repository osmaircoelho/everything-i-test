<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\post;

test('an email as sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class);


});


test('an email was sent to user:x', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();

    Mail::assertSent(WelcomeEmail::class,
        fn(WelcomeEmail $email) => $email->hasto($user->email)
    );
});

test('', function () {

});

