<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClassexercisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classexercises', function(Blueprint $table)
		{
			$table->foreign('class_id', 'classexercises_ibfk_1')->references('id')->on('courseclasses')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('classexercises', function(Blueprint $table)
		{
			$table->dropForeign('classexercises_ibfk_1');
		});
	}

}
