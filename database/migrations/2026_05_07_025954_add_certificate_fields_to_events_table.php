<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('events', function (Blueprint $table) {

            if (!Schema::hasColumn('events', 'certificate_title')) {

                $table->string('certificate_title')
                    ->nullable();

            }

            if (!Schema::hasColumn('events', 'certificate_description')) {

                $table->text('certificate_description')
                    ->nullable();

            }

            if (!Schema::hasColumn('events', 'certificate_signature')) {

                $table->string('certificate_signature')
                    ->nullable();

            }

            if (!Schema::hasColumn('events', 'certificate_background')) {

                $table->string('certificate_background')
                    ->nullable();

            }

        });

    }



    public function down(): void
    {

        Schema::table('events', function (Blueprint $table) {

            $table->dropColumn([

                'certificate_title',
                'certificate_description',
                'certificate_signature',
                'certificate_background',

            ]);

        });

    }
};