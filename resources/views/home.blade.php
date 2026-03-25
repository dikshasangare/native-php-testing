<x-layouts.app>
    <div class=""> 
        <div class="py-4 px-4 bg-gray-100">
            <h3 class="mb-2 px-2 text-xl font-bold">All Featured</h3>
        </div>
        <div class="mx-4 mb-5 bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
            <div class="flex flex-row justify-between items-center">
                <a href="{{ route('products.list', ['category' => 'electronics']) }}" class="flex flex-col items-center">
                    <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/beauty.jpg') }}" alt="Beauty" class="h-full w-full object-cover"/>
                    </div>
                    <p class="text-[12px] font-medium text-gray-600 mt-2">Beauty</p>
                </a>

                <a href="{{ route('products.list', ['category' => 'jewelery']) }}" class="flex flex-col items-center">
                    <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/fashion.jpg') }}" alt="Fashion" class="h-full w-full object-cover"/>
                    </div>
                    <p class="text-[12px] font-medium text-gray-600 mt-2">Fashion</p>
                </a>

                <div class="flex flex-col items-center">
                     <a href="{{ route('products.list', ['category' => 'kids']) }}">
                    <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/kids.jpg') }}" alt="Kids" class="h-full w-full object-cover"/>
                    </div>
                    <p class="text-[12px] font-medium text-gray-600 mt-2">Kids</p>
                     </a>
                </div>

                <div class="flex flex-col items-center">
                     <a href="{{ route('products.list', ['category' => 'womens']) }}">
                    <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/womens.jpg') }}" alt="Womens" class="h-full w-full object-cover"/>
                    </div>
                    <p class="text-[12px] font-medium text-gray-600 mt-2">Womens</p>
                     </a>
                </div>

                <div class="flex flex-col items-center">
                    <a href="{{ route('products.list', ['category' => 'mens']) }}">
                    <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/mens.jpg') }}" alt="Mens" class="h-full w-full object-cover"/>
                    </div>
                    <p class="text-[12px] font-medium text-gray-600 mt-2">Mens</p>
                    </a>
                </div>

            </div>
        </div>
        <div class="w-full h-56">
            <livewire:home.mobile-carousel />
        </div>

        <div class="mx-4 rounded-2xl my-5 bg-blue-500 p-5 text-white shadow-lg">
            <div class="grid grid-cols-3 items-center">
                <div class="col-span-2">
                    <h2 class="text-xl font-semibold tracking-tight">Deal of the Day</h2>
                    <div class="mt-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium opacity-90">22h 55m 20s remaining</p>
                    </div>
                </div>
                
                <div class="col-span-1 flex justify-end">
                    <button type="button" class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-white focus:ring-4 focus:ring-brand-medium shadow-xs rounded-lg font-medium leading-5 rounded-base text-xs p-2 focus:outline-none">
                        View All
                        <svg class="w-4 h-4 ms-1 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                        </svg>
                </div>
            </div>
        </div>

        <div class="mx-4">
            <h3 class="mb-4 text-lg font-bold">Featured Products</h3>
        </div>

        <div class="mx-4 rounded-2xl my-5 bg-rose-400 p-5 text-white shadow-lg">
            <div class="grid grid-cols-3 items-center">
                <div class="col-span-2">
                    <h2 class="text-xl font-semibold tracking-tight">Trending Products </h2>
                    <div class="mt-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3" >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>

                        <p class="text-sm font-medium opacity-90">Last Date 29/02/22</p>
                    </div>
                </div>
                
                <div class="col-span-1 flex justify-end">
                    <a href="{{ route('trading-product') }}" wire:navigate class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-white focus:ring-4 focus:ring-brand-medium shadow-xs rounded-lg font-medium leading-5 rounded-base text-xs p-2 focus:outline-none">
                        View All
                        <svg class="w-4 h-4 ms-1 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>