<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseclassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courseclasses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('class_name', 100);
			$table->text('class_description', 500);
			$table->integer('language_id');
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->integer('discipline_id')->nullable()->index('discipline_id');
			$table->integer('grade_id')->nullable()->index('grade_id');
			$table->integer('teacher_userid');
            $table->string('iconurl',255);
			$table->enum('isavailable', array('Y','N',''));
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
		Schema::drop('courseclasses');
	}

}
