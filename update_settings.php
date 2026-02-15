<?php
use App\Settings\GeneralSettings;

$settings = app(GeneralSettings::class);
$settings->support_email = 'shihabhajbe@gmail.com';
$settings->save();

echo "Admin email set to: " . $settings->support_email . PHP_EOL;
