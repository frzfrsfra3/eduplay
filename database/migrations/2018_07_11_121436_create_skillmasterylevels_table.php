<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillmasterylevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skillmasterylevels', function (Blueprint $table) {
            $table->increments('id');

            $table->string('levelname', 250)->nullable();;
            $table->string('level_massage', 250)->nullable();;

            $table->integer('min_score')->default(0);
            $table->integer('max_score')->default(0);
            $table->integer('min_consecutive_value')->default(0);
            $table->integer('max_consecutive_value')->default(0);


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
        Schema::dropIfExists('skillmasterylevels');
    }
}
