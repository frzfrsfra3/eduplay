<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exams', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('examtype', array('homework','test','practice',''));
			$table->string('title', 250);
            $table->integer('teacheruser_id');
            $table->enum('isavailable', array('Y','N',''));
			$table->integer('skillcategory_id')->nullable();
			$table->integer('skill_id')->nullable();
			$table->integer('maxpoints')->nullable();
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
		Schema::drop('exams');
	}

}
