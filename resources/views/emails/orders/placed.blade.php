<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }} #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 14px; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #D4AF37; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { max-height: 80px; }
        .invoice-title { font-size: 24px; font-weight: bold; color: #D4AF37; text-transform: uppercase; margin-top: 10px; }
        .company-details { font-size: 12px; color: #555; margin-bottom: 20px; text-align: center; }
        .billing-info { background: #f9f9f9; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #D4AF37; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th { background: #f9f9f9; color: #1a1a1a; padding: 10px; text-align: left; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #D4AF37; }
        .table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #D4AF37; color: #1a1a1a; padding-top: 15px; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .btn { display: inline-block; background-color: #D4AF37; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($settings->logo)
                <img src="{{ $message->embed(storage_path('app/public/' . $settings->logo)) }}" alt="{{ $settings->site_name }}" class="logo">
            @else
                <h2>{{ $settings->site_name }}</h2>
            @endif
            <div class="invoice-title">{{ __('Invoice') }} #{{ $order->id }}</div>
            <div class="company-details">
                <strong>{{ $settings->site_name }}</strong><br>
                {{ $settings->support_email }} | {{ $settings->whatsapp_number }}
            </div>
        </div>

        <div class="billing-info">
            <strong>{{ __('Billed To:') }}</strong><br>
            {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
            {{ $order->shipping_address['address'] ?? '' }}<br>
            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['zip'] ?? '' }}<br>
            {{ $order->shipping_address['country'] ?? '' }}<br>
            {{ $order->shipping_address['email'] ?? '' }} | {{ $order->shipping_address['phone'] ?? '' }}
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Qty') }}</th>
                    <th style="text-align: right;">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item['name'] }}
                        @if(isset($item['variant_name']))
                            <br><small style="color: #888;">{{ $item['variant_name'] }}</small>
                        @endif
                    </td>
                    <td>{{ $item['quantity'] }}</td>
                    <td style="text-align: right;">{{ number_format($item['price'] * $item['quantity'], 2) }} €</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">{{ __('Total') }}</td>
                    <td>{{ number_format($order->total_eur, 2) }} €</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: center;">
            <a href="{{ route('order.track') }}?order_id={{ $order->id }}&email={{ urlencode($order->shipping_address['email'] ?? '') }}" class="btn">{{ __('Track Order') }}</a>
        </div>

        <div class="footer">
            <p>{{ __('Thank you for your business!') }}</p>
            <p>&copy; {{ date('Y') }} {{ $settings->site_name }}. {{ __('All rights reserved.') }}</p>
            @if(isset($settings->social_media_links))
                <p>
                @foreach($settings->social_media_links as $link)
                    <a href="{{ $link['url'] }}" style="color: #D4AF37; margin: 0 5px; text-decoration: none;">{{ ucfirst($link['platform']) }}</a>
                @endforeach
                </p>
            @endif
        </div>
    </div>
</body>
</html>
