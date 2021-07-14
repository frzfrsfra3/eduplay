<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurriculaGradelistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('curricula_gradelists', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('curriculum_gradelist_name', 250);
			$table->text('description', 500);
			$table->integer('country_id')->index('country_id');
			$table->enum('approve_status', array('pending','approved','declined',''));
			$table->integer('createdby');
			$table->integer('updatedby');
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
		Schema::drop('curricula_gradelists');
	}

}
