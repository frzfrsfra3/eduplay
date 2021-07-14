<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSkillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('skills', function(Blueprint $table)
		{
			$table->foreign('skill_category_id', 'skills_ibfk_1')->references('id')->on('skillcategories')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('skills', function(Blueprint $table)
		{
			$table->dropForeign('skills_ibfk_1');
		});
	}

}
