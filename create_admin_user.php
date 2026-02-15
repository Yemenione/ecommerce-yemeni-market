<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$user = User::firstOrCreate(
    ['email' => 'admin@yemenimarket.com'],
    [
        'name' => 'Admin User',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]
);

echo "Admin User Created/Verified:\n";
echo "Email: " . $user->email . "\n";
echo "Password: password\n";
