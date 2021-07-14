<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserbadgesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userbadges', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->integer('badge_id');
			$table->string('badgetitle', 250);
			$table->string('badgedescription', 250);
			$table->integer('points')->nullable();
			$table->enum('type',['skill','point','activity'])->default('skill');
			$table->enum('skill_type',['exam','practices'])->default('practices');
			$table->integer('discipline_id')->nullable();
			$table->integer('grade_id')->nullable();
			$table->integer('activity_id')->nullable();
			$table->timestamp('dateacquired')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('userbadges');
	}

}
