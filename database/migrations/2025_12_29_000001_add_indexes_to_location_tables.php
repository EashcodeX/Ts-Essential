<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToLocationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->index('country_id');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->index('state_id');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropIndex(['country_id']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropIndex(['state_id']);
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropIndex(['city_id']);
        });
    }
}
