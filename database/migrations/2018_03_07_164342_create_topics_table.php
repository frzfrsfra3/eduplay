<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topics', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('topic_name', 250);
			$table->string('topic_name_ar', 250)->nullable();
			$table->string('topic_name_fr', 250)->nullable();
			$table->string('iconurl', 250)->nullable();
			$table->enum('approve_status', array('pending','approved','declined',''))->default('pending');
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
		Schema::drop('topics');
	}

}
