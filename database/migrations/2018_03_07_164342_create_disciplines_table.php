<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDisciplinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disciplines', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('discipline_name', 200);
			$table->string('description', 500);
			$table->integer('curriculum_gradelist_id')->nullable()->index('curriculum_gradelist_id');
            $table->integer('group_id')->nullable();
            $table->integer('topic_id')->nullable();
			$table->string('iconurl', 50)->nullable();
            $table->string('color', 10)->nullable();
            $table->integer('language_preference_id');
			$table->enum('approve_status', array('pending','approved','declined',''))->default('pending');
			$table->enum('publish_status', array('draft','published','unpublished',''))->default('draft');
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
		Schema::drop('disciplines');
	}

}
