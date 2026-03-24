<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::livewire('/trading-product', 'product.trading-product')->name('trading-product');

Route::livewire('/product/{id}', 'product.product-show')->name('products.show');
