<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {

            $table->string('venue')->nullable();
            $table->text('address')->nullable();
            $table->integer('max_participants')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            $table->dropColumn([
                'venue',
                'address',
                'max_participants'
            ]);

        });
    }
};