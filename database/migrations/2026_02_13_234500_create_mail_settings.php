<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Settings are stored in the 'settings' table by Spatie Laravel Settings
        // We just need to ensure the group 'mail' is initialized if we want defaults,
        // or just let the settings page handle it.
    }
};
