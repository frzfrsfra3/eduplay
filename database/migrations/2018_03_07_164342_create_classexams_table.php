<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassexamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classexams', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('class_id')->index('class_id');
			$table->integer('exam_id');
            $table->dateTime('exam_start_date')->nullable();
            $table->dateTime('exam_end_date')->nullable();
			$table->timestamp('addedon')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classexams');
	}

}
