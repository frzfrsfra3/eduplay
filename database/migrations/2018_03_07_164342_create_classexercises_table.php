<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassexercisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classexercises', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('class_id')->index('class_id');
			$table->integer('exercise_id');
			$table->enum('status', ['public', 'private'])->default('private');
			$table->timestamp('addedon')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classexercises');
	}

}
