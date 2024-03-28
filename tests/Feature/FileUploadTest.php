<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\{actingAs, post, assertDatabaseCount, assertDatabaseHas};

it('should be able to upload an image', function (){
    Storage::fake('avatar');

    $user = User::factory()->create();

    actingAs($user);

    $file = UploadedFile::fake()->image('image.jpg');

    post(route('upload-avatar'), [
        'file' => $file
    ])->assertOk();

    Storage::disk('avatar')->assertExists($file->hashName());
});
