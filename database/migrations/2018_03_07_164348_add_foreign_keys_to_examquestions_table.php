<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToExamquestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('examquestions', function(Blueprint $table)
		{
			$table->foreign('exam_id', 'examquestions_ibfk_1')->references('id')->on('exams')->onDelete('CASCADE');
			$table->foreign('question_id', 'examquestions_ibfk_2')->references('id')->on('questions')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('examquestions', function(Blueprint $table)
		{
            $table->dropForeign('examquestions_ibfk_2');
            $table->dropForeign('examquestions_ibfk_1');

		});
	}

}
