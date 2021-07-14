<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserexamanswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Schema::table('userexamanswers', function(Blueprint $table)
		{
			$table->foreign('exam_id', 'userexamanswers_ibfk_1')->references('id')->on('exams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'userexamanswers_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		}); */
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/* Schema::table('userexamanswers', function(Blueprint $table)
		{
			$table->dropForeign('userexamanswers_ibfk_1');
			$table->dropForeign('userexamanswers_ibfk_2');
		}); */
	}

}
