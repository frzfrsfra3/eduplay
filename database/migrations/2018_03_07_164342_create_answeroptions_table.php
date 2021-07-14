<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnsweroptionsTable extends Migration {

	/**
	 * Theses are the answer options of the questions available in the exercise set
	 */
	public function up()
	{
		Schema::create('answeroptions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('question_id')->index('question_id');
			$table->enum('answer_type', array('text','image','audio','video','richtext'));
			$table->text('details', 65535);
			$table->text('json_details', 65535);
			$table->boolean('iscorrect')->default(0);
			$table->integer('sort_order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answeroptions');
	}

}
