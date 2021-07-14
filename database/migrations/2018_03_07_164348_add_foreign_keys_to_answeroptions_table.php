<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAnsweroptionsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
    public function up()
    {
        Schema::table('answeroptions', function(Blueprint $table)
        {
            $table->foreign('question_id', 'answeroptions_ibfk_1')->references('id')->on('questions')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('answeroptions', function(Blueprint $table)
        {
            $table->dropForeign('answeroptions_ibfk_1');
        });
    }

}
