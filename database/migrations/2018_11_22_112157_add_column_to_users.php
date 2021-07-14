<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('native_language', 250)->after('aboutme');
            $table->string('linkedin_url', 250)->after('native_language');
            $table->string('city', 250)->after('linkedin_url');
            $table->string('state', 250)->after('city');
            $table->integer('child_password_reset')->default(1)->after('isactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn(['native_language','linkedin_url','city','state','child_password_reset']);
        });
    }
}
