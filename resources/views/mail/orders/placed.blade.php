<x-mail::message>
# Your Order have been Placed Successdully!

Thank You for Using the E-Commerce Store, Your Order ID is {{ $order->id }}.

<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
