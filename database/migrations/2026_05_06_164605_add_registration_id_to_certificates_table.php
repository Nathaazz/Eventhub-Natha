<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('certificates', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | REGISTRATION ID
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('certificates', 'registration_id')) {

                $table->unsignedBigInteger('registration_id')
                    ->nullable()
                    ->after('event_id');

            }

        });

    }



    public function down(): void
    {

        Schema::table('certificates', function (Blueprint $table) {

            if (Schema::hasColumn('certificates', 'registration_id')) {

                $table->dropColumn('registration_id');

            }

        });

    }
};