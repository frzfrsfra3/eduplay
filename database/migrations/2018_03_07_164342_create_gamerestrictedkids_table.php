<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamerestrictedkidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gamerestrictedkids', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('kid_id');
			$table->integer('game_id');
			$table->integer('restricted_by');
			$table->timestamps();
			$table->enum('isactive', array('Y','N',''));
			$table->index(['kid_id','game_id'], 'kid_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gamerestrictedkids');
	}

}
