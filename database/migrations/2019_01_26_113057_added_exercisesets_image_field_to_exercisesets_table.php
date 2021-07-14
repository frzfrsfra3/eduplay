<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedExercisesetsImageFieldToExercisesetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercisesets', function (Blueprint $table) {
            $table->string('exerciseset_image', 250)->nullable()->after('title');
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
            $table->dropColumn(['exerciseset_image']);
        });
    }
}
