<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBadgesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badges', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('badgetitle', 100);
			$table->text('badgedescription', 500);
			$table->string('badgeimageurl', 250);
			$table->integer('points')->nullable();
			$table->integer('badgeorder')->nullable();
			$table->integer('badgegroup')->nullable();
			$table->boolean('isactive')->default(1);
			$table->string('badge_condition', 250);
			$table->enum('badge_type', ['skill', 'points'])->default('points');
			$table->enum('badge_info', ['learning','sharing','general','creation'])->default('sharing');
			$table->timestamp('addedon')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->dateTime('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badges');
	}

}
