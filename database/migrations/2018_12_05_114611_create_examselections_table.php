<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamselectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examselections', function(Blueprint $table)
        {
            $table->integer('id', true);

            $table->integer('exam_id');
            $table->integer('selection_id');
            $table->string('selection_table', 100);
            $table->tinyInteger  ('isselected');
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
        Schema::drop('examselections');
    }

}
