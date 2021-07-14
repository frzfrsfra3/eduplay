<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClasslearnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classlearners', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('class_id')->index('class_id');
			$table->integer('user_id')->index('learner');
            $table->enum('status', array('Pending','Accepted','Rejected','Invited'))->default('Pending');
			$table->timestamp('joindate')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classlearners');
	}

}
