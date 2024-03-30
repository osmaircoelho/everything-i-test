<?php

test('the products route is using the products view')
   ->get('/products')
   ->assertViewis('products');

test('the products route is passing a list of products to the products view')
    ->get('/products')
    ->assertViewIs('products')
    ->assertViewHas('products');
