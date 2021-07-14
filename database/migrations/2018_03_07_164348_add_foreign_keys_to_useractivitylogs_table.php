<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUseractivitylogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('useractivitylogs', function(Blueprint $table)
		{
			$table->foreign('user_id', 'useractivitylogs_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('useractivitylogs', function(Blueprint $table)
		{
			$table->dropForeign('useractivitylogs_ibfk_1');
		});
	}

}
