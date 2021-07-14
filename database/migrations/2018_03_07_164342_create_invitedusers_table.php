<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitedusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invitedusers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('email', 250);
			$table->integer('invitedby');
			$table->text('message', 65535);
			$table->enum('invitationtype', array('parent','child','collaboration','friend',''));
			$table->enum('invitationstatus', array('accepted','rejected','pending',''))->default('pending');
			$table->boolean('isinvitedregistered')->default(0);
			$table->integer('discipline_id')->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invitedusers');
	}

}
