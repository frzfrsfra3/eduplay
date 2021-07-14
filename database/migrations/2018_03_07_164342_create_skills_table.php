<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillsTable extends Migration {

	/**
	 * changed the skills table structure to make it easier to merge with skill categories later
     * */
	public function up()
	{
		Schema::create('skills', function(Blueprint $table)
		{
			$table->integer('id', true);
            $table->string('skill_name', 250);
            $table->string('skill_description', 500);
            $table->integer('skill_category_id');
            // $table->integer('parentskill_id');
            // $table->integer('disciplinescurriculum_id');
			$table->integer('grade_id')->nullable();
			$table->integer('version');
            $table->integer('origin_id')->default(0);
            $table->integer('sort_order')->nullable();
            $table->integer('new_sort_order')->nullable();
            $table->enum('publish_status', array('published','unpublished','deleted'))->default('unpublished');
			$table->enum('approve_status', array('pending','approved','declined','changed','not changed'))->default('pending');
			$table->integer('createdby');
			$table->integer('updatedby');
			$table->integer('moderatedby')->default(0);
            $table->integer('publishedby')->default(0);
			$table->timestamps();
            $table->index(['skill_category_id','grade_id'], 'skill_category_id');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('skills');
	}

}
