<?php

use Livewire\Component;

new class extends Component{};
?>

    <div x-data="{ 
            activeSlide: 0, 
            slides: [
                'https://plus.unsplash.com/premium_photo-1672883551967-ab11316526b4?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1561715276-a2d087060f1d?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 
                'https://images.unsplash.com/photo-1534452203293-494d7ddbf7e0?q=80&w=1472&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 
                'https://images.unsplash.com/photo-1576072446584-4955dfe17b86?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            ],
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
            init() { setInterval(() => this.next(), 5000) } 
        }" 
        class="relative w-full h-56 bg-slate-800">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute inset-0">
                <!-- Ensure images fill the mobile container correctly -->
                <img :src="slide" class="object-cover w-full h-full" alt="App Preview">
            </div>
        </template>

        <!-- Navigation Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent pointer-events-none"></div>

        <!-- Dots -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="activeSlide === index ? 'bg-indigo-400 w-6' : 'bg-white/50 w-2'"
                        class="h-2 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </div>