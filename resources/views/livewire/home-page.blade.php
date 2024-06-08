<div>
    <x-home.get-started></x-home.get-started> {{-- Including get-started blade section --}}

    @livewire('home.brands') {{-- Including 'home.brands' livewire component --}}
    
    @livewire('home.categories') {{-- Including 'home.brands' livewire component --}}

    <x-home.customer-reviews></x-home.customer-reviews> {{-- Including customer-reviews blade section --}}
</div>