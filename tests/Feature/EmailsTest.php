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

    Mail::assertSent(
        WelcomeEmail::class,
        fn (WelcomeEmail $email) => $email->hasto($user->email)
    );
});

test('email subject should contain the user name', function () {
    $user = User::factory()->create();

    $mail = new WelcomeEmail($user);

    expect($mail)
        ->assertHasSubject('Thank you ' . $user->name);
});

it('email content should contain user email with a text', function () {
    $user = User::factory()->create();

    $mail = new WelcomeEmail($user);

    expect($mail)
        ->assertSeeInHtml($user->email)
        ->assertSeeInHtml('Confirmando que o seu email eh: ' . $user->email);
});
