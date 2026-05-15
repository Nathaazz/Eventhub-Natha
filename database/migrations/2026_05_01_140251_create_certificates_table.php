<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            // 🔥 HARUS SAMA DENGAN events.id
            $table->unsignedBigInteger('event_id');

            $table->string('certificate_number')->unique();
            $table->string('name');
            $table->string('file_path')->nullable();

            $table->timestamps();

            // 🔥 FOREIGN KEY FIX
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

            // 🔥 PASTIKAN ENGINE INNODB
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};