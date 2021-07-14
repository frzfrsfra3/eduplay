<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClasslearnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classlearners', function(Blueprint $table)
		{
			$table->foreign('class_id', 'classlearners_ibfk_1')->references('id')->on('courseclasses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'classlearners_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('classlearners', function(Blueprint $table)
		{
			$table->dropForeign('classlearners_ibfk_1');
			$table->dropForeign('classlearners_ibfk_2');
		});
	}

}
