<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePendingtasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pendingtasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->integer('sender_id');
			$table->string('pending_task_description', 250);
            $table->string('pending_task_action', 250);
			$table->enum('status', array('pending','done',''))->default('pending');
			$table->enum('task_type', array(1,0))->default(0);
			$table->integer('sort')->nullable();
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
		Schema::drop('pendingtasks');
	}

}
