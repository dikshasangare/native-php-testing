<?php

use Livewire\Volt\Component;

new class extends Component {
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }
}; ?>

<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold">User Profile</h1>
    <p>Name: {{ $user?->name }}</p>
</div>