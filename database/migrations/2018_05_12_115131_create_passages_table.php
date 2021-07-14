<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('passage_title', 250);
            $table->text('passage_text', 65535);
            $table->integer('exercise_id')->nullable();
            $table->integer('createdby');
            $table->timestamps();
            $table->index('exercise_id', 'exercise_id');
        });
    }





    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passages');
    }
}
