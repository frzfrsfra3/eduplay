<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->integer('id', true);
            $table->string('param', 250)->nullable();
            $table->integer('question_count')->default(1);;
            $table->text('details', 65535);
            $table->text('json_details', 65535);
			$table->enum('questiontype', array('text','image','audio','video','richtext'));
			$table->integer('skill_id')->nullable();
			$table->integer('skillcategory_id')->nullable();
            $table->integer('passage_id')->nullable();
            $table->integer('size')->nullable();
            $table->integer('maxtime');
            $table->integer('mintime')->default(0);;
			$table->integer('exercise_id')->nullable();
			$table->enum('difficultylevel', array('easy','medium','hard',''));
			$table->text('hint', 65535)->nullable();
			$table->text('tag', 65535)->nullable();
			$table->timestamps();
			$table->index(['skill_id','skillcategory_id','exercise_id' ,'passage_id'], 'skill_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
