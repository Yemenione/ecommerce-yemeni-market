<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Newsletter Subscription') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #1a1a1a;
            padding: 40px 20px;
            text-align: center;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .greeting {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            background-color: #D4AF37;
            color: #1a1a1a;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
        }
        .button:hover {
            background-color: #b5952f;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #eeeeee;
        }
        .social-links {
            margin-top: 10px;
        }
        .social-link {
            color: #D4AF37;
            text-decoration: none;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($logo = \App\Models\GeneralSetting::first()->logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="{{ config('app.name') }}" class="logo">
            @else
                <h1 style="color: #D4AF37; margin: 0; font-size: 28px;">{{ config('app.name') }}</h1>
            @endif
        </div>
        
        <div class="content">
            <div class="greeting">
                {{ __('Welcome to the Family!') }}
            </div>
            
            <p class="message">
                {{ __('Thank you for subscribing to our newsletter. We are thrilled to have you with us.') }}
            </p>
            
            <p class="message">
                {{ __('You will be the first to know about our latest exclusive collections, special offers, and stories from the heart of Yemen.') }}
            </p>
            
            <div class="button-container">
                <a href="{{ url('/') }}" class="button">{{ __('Explore Our Collection') }}</a>
            </div>
            
            <p class="message" style="margin-top: 30px; font-size: 14px; font-style: italic; color: #666;">
                {{ __('"Quality is not an act, it is a habit."') }}
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <p>
                {{ __('You received this email because you signed up on our website.') }}
                <br>
                <a href="{{ url('/') }}" style="color: #888; text-decoration: underline;">{{ __('Unsubscribe') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
