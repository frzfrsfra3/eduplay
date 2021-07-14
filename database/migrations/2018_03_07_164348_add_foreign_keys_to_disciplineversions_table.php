<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDisciplineversionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('disciplineversions', function(Blueprint $table)
		{
			$table->foreign('discipline_id', 'disciplineversions_ibfk_1')->references('id')->on('disciplines')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('disciplineversions', function(Blueprint $table)
		{
			$table->dropForeign('disciplineversions_ibfk_1');
		});
	}

}
