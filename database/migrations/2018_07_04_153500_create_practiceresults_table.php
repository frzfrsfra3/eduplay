<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePracticeresultsTable extends Migration {

	/**
	 * Theses are the answer options of the questions available in the exercise set
	 */
	public function up()
	{
		Schema::create('practiceresults', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('question_id');
            $table->integer('user_id');

            $table->integer('answer_id');
            $table->integer('topics_id')->nullable();;
            $table->integer('exercise_id')->nullable();;

			$table->boolean('iscorrect')->default(0);
			$table->time('total_minutes')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('practiceresults');
	}

}
