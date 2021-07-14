<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToExercisesetbuyersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('exercisesetbuyers', function(Blueprint $table)
		{
			$table->foreign('user_id', 'exercisesetbuyers_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('exercisesetbuyers', function(Blueprint $table)
		{
			$table->dropForeign('exercisesetbuyers_ibfk_1');
		});
	}

}
