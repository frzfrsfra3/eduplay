<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserinterestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userinterests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('discipline_id')->nullable();
			$table->integer('user_id')->index('user_interest');
            $table->integer('language_id')->nullable();
            $table->integer('grade_id')->nullable();
            $table->integer('topic_id')->nullable();
            $table->integer('exercise_type')->default(0);
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
		Schema::drop('userinterests');
	}

}
