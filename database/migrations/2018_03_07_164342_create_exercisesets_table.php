<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExercisesetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exercisesets', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 250);
			$table->integer('discipline_id')->nullable();
			$table->integer('topic_id')->nullable();
			$table->integer('grade_id')->nullable();
			$table->integer('language_id');
            $table->integer('price')->default(0);
			$table->text('description', 65535);
			$table->enum('publish_status', array('private','public',''))->default('private');
			$table->timestamps();
			$table->integer('createdby');
			$table->index(['discipline_id','language_id'], 'discipline_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exercisesets');
	}

}
