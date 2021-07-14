<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserexamscoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userexamscores', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->integer('exam_id')->default(0);
            $table->integer('classexam_id')->default(0);
            $table->integer('game_id')->index('game_id')->default(0);
            $table->integer('match_uid')->nullable();
            $table->integer('score');
			$table->integer('totaltimespent');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('skill_id')->nullable();
		//	$table->index(['user_id','exam_id'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('userexamscores');
	}

}
