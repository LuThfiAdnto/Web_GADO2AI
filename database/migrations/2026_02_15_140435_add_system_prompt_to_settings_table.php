<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom SUDAH ADA?
        if (!Schema::hasColumn('settings', 'system_prompt')) {
            // Kalau BELUM ADA, baru buat kolomnya
            Schema::table('settings', function (Blueprint $table) {
                $table->text('system_prompt')->nullable()->after('ai_active');
            });
        }
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('system_prompt');
        });
    }
};
