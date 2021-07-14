<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamquestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('examquestions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('exam_id')->index('exam_id');
			$table->integer('question_id')->index('question');
            $table->integer('points');
           $table->integer('sort_order')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('examquestions');
	}

}
