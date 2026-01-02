<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state')->nullable()->after('country');
            }
            if (!Schema::hasColumn('users', 'area')) {
                $table->string('area')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'country_code')) {
                $table->string('country_code')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('users', 'area')) {
                $table->dropColumn('area');
            }
            if (Schema::hasColumn('users', 'country_code')) {
                $table->dropColumn('country_code');
            }
        });
    }
}
