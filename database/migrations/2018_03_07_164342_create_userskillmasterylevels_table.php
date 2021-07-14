<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSkillmasterylevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userskillmasterylevels', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->integer('skill_id');
            $table->integer('classexam_id');
			$table->integer('score');
			$table->integer('masteryLevel');
			$table->timestamps();
			$table->index(['user_id','skill_id'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('userskillmasterylevels');
	}

}
