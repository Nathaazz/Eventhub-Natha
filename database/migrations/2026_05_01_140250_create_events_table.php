<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->dateTime('date')->nullable();
            $table->string('location')->nullable();

            $table->string('status')->default('draft');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // 🔥 PASTIKAN ENGINE INNODB
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};