<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 cek di luar closure
        if (!Schema::hasColumn('events', 'is_active')) {
            Schema::table('events', function (Blueprint $table) {
                $table->boolean('is_active')->default(true);
            });
        }
    }

    public function down(): void
    {
        // 🔥 cek di luar closure juga
        if (Schema::hasColumn('events', 'is_active')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};