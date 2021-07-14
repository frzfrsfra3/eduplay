<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('skillcategories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('skill_category_name', 250);
			$table->string('skill_category_decsription', 500);
			$table->integer('version');
            $table->integer('origin_id')->default(0);
            $table->integer('sort_order');
            $table->integer('new_sort_order')->nullable();
            $table->integer('duration')->default(0);
			$table->enum('approve_status', array('pending','approved','declined','changed','not changed'))->default('pending');
			$table->enum('publish_status', array('published','unpublished','deleted'))->default('unpublished');
            $table->integer('discipline_id')->nullable();
            $table->integer('createdby');
			$table->integer('updatedby');
			$table->integer('moderatedby')->default(0);
            $table->integer('publishedby')->default(0);


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
		Schema::drop('skillcategories');
	}

}
