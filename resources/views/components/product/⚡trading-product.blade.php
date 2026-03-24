<?php

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


new #[Title('E-commerce Shop')] #[Layout('layouts.app')] class extends Component
{
    public array $products = [];
    public function mount()
    {
        $this->products = Http::get('https://fakestoreapi.com/products?limit=8')->json();
    }
};
?>


<div class="mx-auto p-2 sm:p-6">
    <h1 class="text-2xl sm:text-3xl font-bold my-5 px-2">Trading Products</h1>

    <div class="grid grid-cols-2 gap-2 sm:gap-6">
        @foreach($products as $product)
            @php
                $rating = $product['rating']['rate'] ?? 0;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.5;
            @endphp
            <div class="bg-white border border-gray-100 rounded-lg sm:rounded-xl overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
                
                <div class=" flex-1">
                    <div class="h-32 sm:h-48 w-full flex items-center justify-center bg-gray-50 rounded-xl mb-2">
                        <img src="{{ $product['image'] }}" class="max-h-full rounded-xl object-contain p-2">
                    </div>

                   <div class="p-2 sm:p-4">
                        <a href="{{ route('products.show', $product['id']) }}" wire:navigate  class="font-bold text-gray-900 text-sm sm:text-base line-clamp-1">
                            {{ $product['title'] }}
                        </a>
                        
                        <p class="text-gray-500 text-[10px] sm:text-xs line-clamp-2 leading-tight min-h-[2.5em]">
                            {{ $product['description'] }}
                        </p>
                        
                        <p class="text-blue-700 font-bold text-sm sm:text-lg mt-2">
                            ${{ number_format($product['price'], 2) }}
                        </p>

                        <div class="flex items-center mt-1 mb-3">
                            <div class="flex items-center text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @elseif ($i == $fullStars + 1 && $hasHalfStar)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 15V0l-2.939 5.955-6.572.955 4.756 4.635-1.123 6.545L10 15z"/></svg>
                                    @else
                                        <svg class="w-3 h-3 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-[10px] text-gray-500 ml-1">({{ $rating }})</span>
                        </div>
                   </div>
                   
                </div>
            </div>
        @endforeach
    </div>
</div>