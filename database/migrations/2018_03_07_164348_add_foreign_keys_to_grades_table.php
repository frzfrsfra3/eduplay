<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGradesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('grades', function(Blueprint $table)
		{
			$table->foreign('curriculum_gradelist_id', 'grades_ibfk_1')->references('id')->on('curricula_gradelists')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('grades', function(Blueprint $table)
		{
			$table->dropForeign('grades_ibfk_1');
		});
	}

}
