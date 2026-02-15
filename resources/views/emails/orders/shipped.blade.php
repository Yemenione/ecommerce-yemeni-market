@component('mail::message')
# Your Order Has Shipped!

Hi {{ $order->user->name ?? 'Customer' }},

Great news! Your order #{{ $order->id }} has been shipped and is on its way to you.

@if($order->tracking_number)
**Tracking Number:** {{ $order->tracking_number }}
@endif

@component('mail::button', ['url' => route('home')])
Track Your Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
