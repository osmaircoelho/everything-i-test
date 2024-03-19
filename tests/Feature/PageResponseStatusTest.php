<?php

use function Pest\Laravel\get;

test('testing code 200')
    ->get('/')
    ->assertOk();

test('testing code 404')

    ->get('/404')
    ->assertNotFound();


test('testing code 403 :: do not have access permissions ')
    ->get('/403')
    ->assertStatus(403)
    ->assertForbidden();


