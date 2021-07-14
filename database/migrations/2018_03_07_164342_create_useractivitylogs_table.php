<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUseractivitylogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('useractivitylogs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('activity_id');
			$table->integer('user_id')->index('user_id');
            $table->integer('points');
            $table->integer('accumulated_points');
			$table->text('details')->nullable();
			$table->string('device', 500)->nullable();
			$table->string('browserinformation', 500)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('useractivitylogs');
	}

}
