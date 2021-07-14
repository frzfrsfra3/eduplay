<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToClassexamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classexams', function(Blueprint $table)
		{
			$table->foreign('class_id', 'classexams_ibfk_1')->references('id')->on('courseclasses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('classexams', function(Blueprint $table)
		{
			$table->dropForeign('classexams_ibfk_1');
		});
	}

}
