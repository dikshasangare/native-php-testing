<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Title('Products')] #[Layout('layouts.app')] class extends Component
{
    use WithPagination;

    public $category = null;

    public function mount()
    {
        $this->category = request()->query('category');
    }

    #[Computed]
    public function products()
    {
        $response = Http::get('https://fakestoreapi.com/products')->json();

        $collection = collect($response)->map(function ($item) {
            return (object) [
                'id' => $item['id'],
                'title' => $item['title'],
                'price' => $item['price'],
                'image' => $item['image'],
                'category' => $item['category'],
            ];
        });

        // CATEGORY MAP
        $map = [
            'mens' => "men's clothing",
            'womens' => "women's clothing",
            'beauty' => "jewelery",
            'fashion' => "electronics",
        ];

        // FILTER
        if ($this->category && isset($map[$this->category])) {
            $collection = $collection->where('category', $map[$this->category]);
        }

        $perPage = 8;
        $page = $this->page ?? 1;

        return new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
    }

    public function with(): array
    {
        return [
            'products' => $this->products,
        ];
    }
};
?>

<div class="mx-auto p-2 sm:p-6">
    <div class="flex justify-between items-center px-2">
        <h1 class="text-2xl sm:text-3xl font-bold my-5 px-2"> {{ ucfirst($category ?? 'Products') }}</h1>
        <!-- Loading Indicator -->
        <div wire:loading class="text-blue-600 animate-pulse text-sm font-medium">
            Updating...
        </div>
    </div>
    @if($products->isNotEmpty())
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-6">
            @foreach($products as $product)
                @php
                    $rating = $product->rating_rate ?? 0; 
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                @endphp
                <div class="bg-white border border-gray-100 rounded-lg sm:rounded-xl overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-md transition-all">
                    <div class="flex-1">
                        <div class="h-32 sm:h-48 w-full flex items-center justify-center bg-gray-50">
                            <img src="{{ $product->image }}" class="max-h-full p-4 object-contain">
                        </div>

                        <div class="p-2 sm:p-4">
                            <a href="{{ route('products.show', $product->id) }}" wire:navigate class="font-bold text-gray-900 text-sm sm:text-base line-clamp-1">
                                {{ $product->title }}
                            </a>
                            <p class="text-blue-700 font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="py-20 mt-5 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
        </div>
    @endif
</div>
