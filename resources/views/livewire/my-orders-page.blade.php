<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">
        My Orders
    </h1>

    <div class="flex flex-col bg-white p-5 rounded mt-4 shadow-lg">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            @if (count($orders) > 0)
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Order
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Date
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Order Status
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Payment Status
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Order Amount
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>
                            @endif
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    // Changing the color of the Order status.
                                    $order_status_color = '';

                                    if($order->status == 'new'){
                                        $order_status_color = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">New</span>';
                                    } 
                                    elseif($order->status == 'processing'){
                                        $order_status_color = '<span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">Processing</span>';
                                    } 
                                    elseif($order->status == 'shipped'){
                                        $order_status_color = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Shipped</span>';
                                    } 
                                    elseif($order->status == 'deliverd'){
                                        $order_status_color = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Deliverd</span>';
                                    } 
                                    elseif($order->status == 'canceled'){
                                        $order_status_color = '<span class="bg-red-500 py-1 px-3 rounded text-white shadow">Canceled</span>';
                                    }

                                    // Changing the color of the Payment status.
                                    $payment_status_color = '';

                                    if($order->payment_status == 'pending'){
                                        $payment_status_color = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">Pending</span>';
                                    } 
                                    elseif($order->payment_status == 'paid'){
                                        $payment_status_color = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Paid</span>';
                                    } 
                                    elseif($order->payment_status == 'failed'){
                                        $payment_status_color = '<span class="bg-red-500 py-1 px-3 rounded text-white shadow">Failed</span>';
                                    }
                                @endphp

                                <tr wire:key="{{ $order->id }}" class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                    {{-- Order ID --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->id }}
                                    </td>

                                    {{-- Order Creation Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        {{ $order->created_at->format('d-m-Y') }}
                                    </td>

                                    {{-- Order Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        {!! $order_status_color !!}
                                    </td>

                                    {{-- Order Payment Method --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        {!! $payment_status_color !!}
                                    </td>

                                    {{-- Order Grand Total --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        {{ Number::currency($order->grand_total, 'USD') }}
                                    </td>

                                    {{-- View Details Button --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <a href="{{ route('my-orders.show', $order) }}" class="bg-slate-600 text-white py-2 px-4 rounded-md hover:bg-slate-500">
                                            View Details
                                        </a>
                                    </td>
                                </tr>                                
                            @empty
                                <p class="text-center">
                                    You don't have any orders yet, get some Products from  
                                    <a href="{{ route('products') }}" class="text-blue-500  hover:text-blue-700">
                                        Products Page
                                    </a>
                                </p>
                            @endforelse 
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Links --}}
            {{ $orders->links() }}
        </div>
    </div>
</div>