<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSkillCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_skill_categories', function (Blueprint $table) {
            $table->primary(['exam_id', 'skill_category_id']);
            $table->integer('skill_category_id');
            //$table->foreign('skill_category_id')->references('id')->on('skillcategories');
            $table->string('skill_count', 250);
            $table->integer('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams');
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
        Schema::dropIfExists('exam_skill_categories');
    }
}
