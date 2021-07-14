<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamePreferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_preferences', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('user_id');
            $table->string('code', 10);
            $table->integer('grade_id')->nullable();
			$table->integer('discipline_id')->nullable();
			$table->integer('maxtime')->nullable();
			$table->integer('questiontype')->nullable();
			$table->integer('topic_id');
            $table->string('list_exercise_ids', 100);
			$table->integer('language_id')->nullable();
			$table->integer('size')->nullable();
            $table->integer('haspassage')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('game_preferences');
	}

}
