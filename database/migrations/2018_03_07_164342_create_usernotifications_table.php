<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsernotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usernotifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('receiver_userid');
			$table->integer('sender_userid')->index('receiver_userid');
			$table->text('notification', 65535);
			$table->integer('action_id')->nullable();
			$table->timestamps();
			$table->enum('status', array('Y','N',''))->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usernotifications');
	}

}
