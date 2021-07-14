<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_disciplines', function (Blueprint $table) {
            $table->primary(['exam_id', 'discipline_id']);
            $table->integer('discipline_id');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
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
        Schema::dropIfExists('exam_disciplines');
    }
}
