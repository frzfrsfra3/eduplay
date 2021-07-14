<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamedetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gamedetails', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('platform_id');
			$table->integer('game_id');
			$table->string('android_link', 500)->nullable();
			$table->string('ios_link', 500)->nullable();
			$table->string('ios_bundle_id', 500)->nullable();
			$table->string('ios_url_scheme_suffix', 500)->nullable();
			$table->string('ios_iphone_store_id', 500)->nullable();
			$table->string('ios_ipad_store_id', 500)->nullable();
			$table->string('android_package_name', 500)->nullable();
			$table->string('android_key_hashes', 500)->nullable();
			$table->string('android_class_name', 500)->nullable();
			$table->string('android_amazon_url', 500)->nullable();
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
		Schema::drop('gamedetails');
	}

}
