<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserexamanswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userexamanswers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->timestamp('answerdate')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('user_id');
			$table->integer('exam_id')->index('exam_id');
            $table->integer('class_id');
            $table->integer('classexam_id');
			$table->integer('attempt_number')->default(0);;
			$table->integer('question_id');
			$table->integer('answer_id');
			$table->integer('timespent');
			$table->integer('iscorrect');
            $table->integer('params')->default(0);
            $table->integer('match_uid');
            $table->timestamp('match_datetime');

           // $table->enum('iscorrect', array('0','1',''));
			$table->integer('teachermark')->nullable();
			$table->integer('pointsgained')->nullable();
			$table->integer('gameid')->nullable();
			$table->text('user_agent', 65535)->nullable();
			$table->index(['user_id','exam_id'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('userexamanswers');
	}

}
