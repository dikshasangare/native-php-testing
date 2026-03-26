<?php

use \App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Native\Mobile\Facades\Notification;

new #[Title('E-commerce Shop')] #[Layout('layouts.app')] class extends Component
{
    public int $id; 
    public array $product = [];
    public bool $loading = true;
    public bool $expanded = false;
    public array $similarProducts = []; 
    public $isWishlisted = false;

    public function mount()
    {
        // Fetch the specific product from the API
        $response = Http::get("https://fakestoreapi.com/products/{$this->id}");
        
          if ($response->successful()) {
            $this->product = $response->json();
            // ✅ CHECK WISHLIST (USER OR GUEST)
            $userId = Auth::id() ?? 1;
            $sessionId = session()->getId();

            $query = Wishlist::where('product_id', $this->id);

            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }

            $this->isWishlisted = $query->exists();

            // 2. Fetch Similar Products using the category from the main product
            $category = $this->product['category'];
            $similarResponse = Http::get("https://fakestoreapi.com/products/category/{$category}");
            
            if ($similarResponse->successful()) {
                // Filter out current product and take only 4
                $this->similarProducts = collect($similarResponse->json())
                    ->filter(fn($item) => $item['id'] != $this->id)
                    ->take(4)
                    ->toArray();
            }
        }
        
        $this->loading = false;
    }

    public function toggleDescription()
    {
        $this->expanded = !$this->expanded;
    }

    public function wishlistToggle(): void
    {
        $userId = Auth::id() ?? 1;
        $sessionId = session()->getId();

        $query = Wishlist::where('product_id', $this->id);

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $wishlist = $query->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->isWishlisted = false;
             // $this->notify('Removed from wishlist ❌');
        } else {
            Wishlist::create([
                'user_id' => $userId ?? 1,
                'session_id' => $sessionId,
                'product_id' => $this->id
            ]);

            $this->isWishlisted = true;
            // $this->notify('Added to wishlist ❤️');
        }
    }

    // ✅ Unified notification handler
    // private function notify(string $message): void
    // {
    //     // NativePHP Mobile
    //     if (class_exists(FacadesNotification::class)) {
    //         FacadesNotification::title('Wishlist')
    //             ->body($message)
    //             ->send();
    //     }

    //     // Web fallback (Livewire event)
    //     $this->dispatch('toast', message: $message);
    // }

};
?>

<div class="max-w-7xl mx-auto p-4 sm:p-10">
    <a href="{{ route('trading-product') }}" wire:navigate class="inline-flex items-center text-sm text-gray-500 hover:text-black mb-8 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Products
    </a>

    @if(!$product)
        <div class="text-center py-20">
            <p class="text-gray-500">Product not found...</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-center">
                <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="max-h-[200px] h-[200px] object-contain transform hover:scale-105 transition duration-500">
            </div>

            <div class="flex flex-col">
                <span class="text-xs font-bold tracking-widest text-blue-600 uppercase mb-2">
                    {{ $product['category'] }}
                </span>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    {{ $product['title'] }}
                </h1>

                <div class="flex items-center mb-6">
                    <div class="flex items-center text-yellow-400 mr-2">
                        @php
                            $rate = $product['rating']['rate'] ?? 0;
                            $fullStars = floor($rate);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $fullStars ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500 font-medium">
                        {{ $rate }} ({{ $product['rating']['count'] ?? 0 }} reviews)
                    </span>
                </div>

                <div class="text-4xl font-mono font-bold text-gray-900 mb-3">
                    ${{ number_format($product['price'], 2) }}
                </div>

                <div class="border-t border-gray-100 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 capitalize tracking-wider mb-4">Product Details</h3>
                    <p class="text-gray-600 leading-relaxed text-lg {{ $expanded ? '' : 'line-clamp-3' }}">
                        {{ $product['description'] }}
                    </p>
                    @if(strlen($product['description']) > 10)
                        <button wire:click="toggleDescription" class="mt-2 text-blue-600 font-bold text-sm hover:underline focus:outline-none">
                            {{ $expanded ? 'Show Less ↑' : 'Read More ↓' }}
                        </button>
                    @endif
                </div>

                <div class="mt-auto grid grid-cols-2 gap-4">
                    <button class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-all shadow-lg hover:shadow-blue-200">
                        <div class="bg-white rounded-full p-4 mr-3 shadow-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xs tracking-wide py-2">Add to Cart</span>
                    </button>

                    <button wire:click="wishlistToggle" class="inline-flex items-center  hover:bg-blue-700  {{ $isWishlisted ? 'bg-red-500' : 'bg-blue-600' }} text-white rounded-full transition-all shadow-lg hover:shadow-blue-200">
                        <div class="bg-white rounded-full p-4 mr-3 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="w-5 h-5 {{ $isWishlisted ? 'text-red-500' : 'text-blue-600' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xs tracking-wide py-2"> {{ $isWishlisted ? 'Wishlisted' : 'Add to Wishlist' }}</span>
                    </button>
                    
                </div>
            </div>

            <div class="border-t border-gray-100 pt-2">
                <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-8">Similar Products</h3>
                <div class="grid grid-cols-2 gap-2 sm:gap-6">
                    @foreach($similarProducts as $product)
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
                                  
                                    <div class="flex justify-between items-center">
                                        <span class="text-blue-700 font-bold text-sm sm:text-lg mt-2">${{ number_format($product['price'], 2) }}</span>
                                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-tighter mt-2">{{ $product['category'] }}</span>
                                    </div>

                                </div>

                                <div class="flex items-center mb-3 px-2 sm:px-4">
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
                    @endforeach
                </div>
            </div>

        </div>
    @endif
</div>