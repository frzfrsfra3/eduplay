<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rating');
            $table->string('title',100);
            $table->string('body',250);
          //  $table->morphs('reviewrateable');
          //  $table->morphs('author');
            $table->integer('reviewrateable_id');
            $table->string('reviewrateable_type',250);
            $table->integer('author_id');
            $table->string('author_type',250);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
