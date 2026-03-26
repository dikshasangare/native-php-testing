<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductService
{
    public function all()
    {
        return Http::get('https://fakestoreapi.com/products')->json();
    }

    public function find($id)
    {
        return Http::get("https://fakestoreapi.com/products/{$id}")->json();
    }
}