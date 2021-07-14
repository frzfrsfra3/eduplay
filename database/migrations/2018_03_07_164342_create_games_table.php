<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('discipline_id');
			$table->integer('developer_id');
			$table->string('game_name' ,250);
			$table->enum('patform', array('IOS','android',''));
			$table->string('app_id', 500);
			$table->string('secrete_key', 500);
			$table->string('game_icon', 250);
			$table->string('image1', 250);
			$table->string('image2', 250);
			$table->string('image3', 250);
			$table->string('image4', 250);
			$table->string('image5', 250);
			$table->string('category',250);
			$table->integer('minimum_age');
			$table->enum('status', array('draft','published','unpublished',''));
			$table->enum('isapproved', array('Y','N',''));
			$table->enum('isactive', array('Y','N',''));
			$table->timestamps();
			$table->text('description', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('games');
	}

}
