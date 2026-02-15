<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->text('subheadline')->nullable()->after('headline');
            $table->string('pre_title')->nullable()->after('image');
            $table->string('cta_text')->nullable()->after('cta_url');
            $table->string('video_url')->nullable()->after('cta_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['subheadline', 'pre_title', 'cta_text', 'video_url']);
        });
    }
};
