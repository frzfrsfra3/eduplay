<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessrulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('businessrules', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('businessrule_name', 250);
			$table->string('businessrule_condition', 250);
			$table->boolean('isactive')->default(1);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('businessrules');
	}

}
