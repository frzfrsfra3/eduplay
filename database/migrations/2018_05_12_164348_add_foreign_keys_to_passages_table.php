<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPassagesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
    public function up()
    {
        Schema::table('passages', function(Blueprint $table)
        {
            $table->foreign('exercise_id', 'passages_ibfk_1')->references('id')->on('exercisesets')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('passages', function(Blueprint $table)
        {
            $table->dropForeign('passages_ibfk_1');
        });
    }

}
