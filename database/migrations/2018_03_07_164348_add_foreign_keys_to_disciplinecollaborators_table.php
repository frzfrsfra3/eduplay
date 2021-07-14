<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDisciplinecollaboratorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('disciplinecollaborators', function(Blueprint $table)
		{
			$table->foreign('discipline_id', 'disciplinecollaborators_ibfk_1')->references('id')->on('disciplines')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'disciplinecollaborators_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('disciplinecollaborators', function(Blueprint $table)
		{
			$table->dropForeign('disciplinecollaborators_ibfk_1');
			$table->dropForeign('disciplinecollaborators_ibfk_2');
		});
	}

}
