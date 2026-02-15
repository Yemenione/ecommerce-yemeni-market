<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }} #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 14px; color: #333; margin: 0; padding: 0; }
        .header { width: 100%; border-bottom: 2px solid #D4AF37; padding-bottom: 20px; margin-bottom: 30px; overflow: hidden; }
        .logo-container { float: left; width: 50%; }
        .logo-container img { max-height: 80px; }
        .logo-text { font-size: 24px; font-weight: bold; color: #D4AF37; text-transform: uppercase; line-height: 80px; }
        .company-details { float: right; width: 40%; text-align: right; font-size: 12px; color: #555; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #1a1a1a; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; clear: both; padding-top: 20px; }
        .invoice-info { margin-bottom: 30px; overflow: hidden; }
        .col-left { float: left; width: 45%; }
        .col-right { float: right; width: 45%; text-align: right; }
        .section-title { font-weight: bold; font-size: 12px; text-transform: uppercase; color: #888; margin-bottom: 5px; border-bottom: 1px solid #eee; padding-bottom: 2px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table th { background-color: #f9f9f9; color: #1a1a1a; font-weight: bold; text-transform: uppercase; font-size: 11px; padding: 12px 8px; border-bottom: 2px solid #D4AF37; text-align: left; }
        .table td { padding: 12px 8px; border-bottom: 1px solid #eee; vertical-align: top; }
        .table tr:nth-child(even) { background-color: #fcfcfc; }
        .total-section { float: right; width: 40%; }
        .total-row { overflow: hidden; margin-bottom: 5px; }
        .total-label { float: left; font-weight: bold; color: #555; }
        .total-value { float: right; font-weight: bold; color: #1a1a1a; }
        .grand-total { border-top: 2px solid #D4AF37; padding-top: 10px; margin-top: 10px; font-size: 16px; color: #D4AF37; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 20px; text-align: center; border-top: 1px solid #eee; font-size: 10px; color: #888; }
        .status-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; background-color: #eee; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
        <div class="logo-container">
            @if(isset($settings) && $settings->logo && file_exists(storage_path('app/public/' . $settings->logo)))
                @php
                    $path = storage_path('app/public/' . $settings->logo);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" alt="{{ $settings->site_name }}" style="max-height: 80px;">
            @else
                <div class="logo-text">{{ $settings->site_name ?? 'Yemeni Market' }}</div>
            @endif
        </div>
        </div>
        <div class="company-details">
            <strong>{{ $settings->site_name ?? 'Yemeni Market' }}</strong><br>
            @if(isset($settings) && $settings->support_email)
                Email: {{ $settings->support_email }}<br>
            @endif
            @if(isset($settings) && $settings->whatsapp_number)
                Phone: {{ $settings->whatsapp_number }}<br>
            @endif
        </div>
    </div>

    <div class="invoice-title">
        {{ __('Invoice') }} #{{ $order->id }}
    </div>

    <div class="invoice-info">
        <div class="col-left">
            <div class="section-title">{{ __('Billed To') }}</div>
            <strong>{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</strong><br>
            {{ $order->shipping_address['address'] ?? '' }}<br>
            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['zip'] ?? '' }}<br>
            {{ $order->shipping_address['country'] ?? '' }}<br>
            {{ $order->shipping_address['email'] ?? '' }}<br>
            {{ $order->shipping_address['phone'] ?? '' }}
        </div>
        <div class="col-right">
            <div class="section-title">{{ __('Order Details') }}</div>
            <strong>{{ __('Date') }}:</strong> {{ $order->created_at->format('F j, Y') }}<br>
            <strong>{{ __('Status') }}:</strong> {{ $order->status->getLabel() }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Item') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th style="text-align: right;">{{ __('Price') }}</th>
                <th style="text-align: right;">{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item['name'] }}</strong>
                     @if(isset($item['variant_name']) && $item['variant_name'])
                        <br><small style="color: #888;">{{ $item['variant_name'] }}</small>
                    @endif
                </td>
                <td>{{ $item['quantity'] }}</td>
                <td style="text-align: right;">{{ number_format($item['price'], 2) }} €</td>
                <td style="text-align: right;">{{ number_format(($item['price'] * $item['quantity']), 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">{{ __('Subtotal') }}:</span>
            <span class="total-value">{{ number_format($order->subtotal_eur, 2) }} €</span>
        </div>
        <div class="total-row">
            <span class="total-label">{{ __('Shipping') }}:</span>
            <span class="total-value">{{ number_format($order->shipping_cost, 2) }} €</span>
        </div>
        @if($order->tax_amount > 0)
        <div class="total-row">
            <span class="total-label">{{ __('Tax') }}:</span>
            <span class="total-value">{{ number_format($order->tax_amount, 2) }} €</span>
        </div>
        @endif
        <div class="total-row grand-total">
            <span class="total-label">{{ __('Total') }}:</span>
            <span class="total-value">{{ number_format($order->total_eur, 2) }} €</span>
        </div>
    </div>

    <div class="footer">
        <p>{{ __('Thank you for shopping with us!') }}</p>
        <p>&copy; {{ date('Y') }} {{ $settings->site_name ?? 'Yemeni Market' }}. {{ __('All rights reserved.') }}</p>
    </div>
</body>
</html>
