<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Profile activities by roletype
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
			$table->integer('id', true);
            $table->string('role_type', 50);
			$table->string('activity_description', 250);
			$table->string('activity_action', 250);
			$table->enum('activity_category', ['sharing','general','creation'])->default('general');
            $table->integer('order');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities');
	}

}
