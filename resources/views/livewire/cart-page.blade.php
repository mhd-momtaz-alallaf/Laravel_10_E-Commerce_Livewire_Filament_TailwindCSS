
<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">
            Shopping Cart
        </h1>

        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                {{-- Cart Items Secction --}}
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        {{-- The table head will show inly if there is som items in the cart --}}
                        @if ($cart_items)
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold">
                                        Product
                                    </th>

                                    <th class="text-left font-semibold">
                                        Price
                                    </th>

                                    <th class="text-left font-semibold">
                                        Quantity
                                    </th>

                                    <th class="text-left font-semibold">
                                        Total
                                    </th>

                                    <th class="text-left font-semibold">
                                        Remove
                                    </th>
                                </tr>
                            </thead>
                        @endif
                        
                        <tbody>
                            @forelse ($cart_items as $item)
                                <tr wire:key="{{ $item['product_id'] }}">
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <img class="h-16 w-16 mr-4" src="{{ url('storage/' . ltrim($item['image'], '/')) }}" alt="{{ $item['name'] }}">
                                            <span class="font-semibold">{{ $item['name'] }}</span>
                                        </div>
                                    </td>

                                    <td class="py-4">
                                        {{ Number::currency($item['unit_amount'], 'USD') }}
                                    </td>

                                    {{-- Quantity Field --}}
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            {{-- Minus Button --}}
                                            <button wire:click="decreaseQuantity({{ $item['product_id'] }})" class="border rounded-md py-2 px-4 mr-2">
                                                -
                                            </button>

                                            {{-- Quantity --}}
                                            <span class="text-center w-8">
                                                {{ $item['quantity'] }}
                                            </span>

                                            {{-- Plus Button --}}
                                            <button wire:click="increaseQuantity({{ $item['product_id'] }})" class="border rounded-md py-2 px-4 ml-2">
                                                +
                                            </button>
                                        </div>
                                    </td>

                                    <td class="py-4">
                                        {{ Number::currency($item['total_amount'], 'USD') }}
                                    </td>

                                    {{-- Remove Button --}}
                                    <td>
                                        <button wire:click="removeItem({{ $item['product_id'] }})" class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">
                                            {{-- Removing Loader, Button Name will Temporally changing just after the user is pressed the remove button, the 'Remove' will be temporally replaced with 'Removing...' as follow: --}}
                                            {{-- Removing the 'Remove' -Button Name- when the event 'removeItem({{ $item['product_id'] }})' is loading --}}
                                            <span wire:loading.remove wire:target='removeItem({{ $item['product_id'] }})'>Remove</span>
                                            {{-- Adding the 'Removing...' -Button Name- when the event 'removeItem({{ $item['product_id'] }})' is loading --}} 
                                            <span wire:loading wire:target='removeItem({{ $item['product_id'] }})'>Removing...</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-2xl font-semibold text-slate-500">No Items Available in the Cart!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary Section --}}
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">
                        Summary
                    </h2>

                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>
                            {{ Number::currency($grand_total, 'USD') }}
                        </span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>
                            {{ Number::currency(0, 'USD') }}
                        </span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>
                            {{ Number::currency(0, 'USD') }}
                        </span>
                    </div>

                    <hr class="my-2">

                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Grand Total</span>
                        <span class="font-semibold">
                            {{ Number::currency($grand_total, 'USD') }}
                        </span>
                    </div>

                    {{-- Checkout Button will show only if there is some items in the cart --}}
                    @if ($cart_items)
                        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">
                            Checkout
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>