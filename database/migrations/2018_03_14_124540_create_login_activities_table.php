<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('login_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('user_agent');
            $table->string('ip_address', 45);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('login_activities');
    }
}
