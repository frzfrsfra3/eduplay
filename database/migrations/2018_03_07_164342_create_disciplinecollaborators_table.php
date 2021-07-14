<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDisciplinecollaboratorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disciplinecollaborators', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('discipline_id')->index('discipline_id');
			$table->integer('user_id')->index('users');
			$table->text('message', 65535);
			$table->boolean('iscoordinator')->default(0);
			$table->enum('approvalstatus', array('pending','approved','declined',''));
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
		Schema::drop('disciplinecollaborators');
	}

}
