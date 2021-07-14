<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedMinAgeAndMaxAgeFieldToExercisesetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercisesets', function (Blueprint $table) {
            $table->integer('minimum_age')->default(0)->after('description');
            $table->integer('maximum_age')->default(0)->after('minimum_age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercisesets', function (Blueprint $table) {
            $table->dropColumn(['minimum_age']);
            $table->dropColumn(['maximum_age']);
        });
    }
}
