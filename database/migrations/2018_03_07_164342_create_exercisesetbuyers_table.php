<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExercisesetbuyersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exercisesetbuyers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('exerciseset_id')->index('exerciseset_id');
			$table->integer('user_id')->index('buyers');
			$table->timestamp('joindate')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exercisesetbuyers');
	}

}
