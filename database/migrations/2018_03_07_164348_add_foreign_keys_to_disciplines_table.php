<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDisciplinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('disciplines', function(Blueprint $table)
		{
			$table->foreign('curriculum_gradelist_id', 'disciplines_ibfk_1')->references('id')->on('curricula_gradelists')->onUpdate('RESTRICT')->onDelete('SET NULL');
            $table->foreign('topic_id', 'disciplines_ibfk_2')->references('id')->on('topics')->onDelete('SET NULL');

        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('disciplines', function(Blueprint $table)
		{
			$table->dropForeign('disciplines_ibfk_1');
            $table->dropForeign('disciplines_ibfk_2');
		});
	}

}
