<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToskillcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
    public function up()
    {
        Schema::table('skillcategories', function(Blueprint $table)
        {
            $table->foreign('discipline_id', 'skillcategories_ibfk_1')->references('id')->on('disciplines')->onDelete('SET NULL');
        });
    }


    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('skillcategories', function(Blueprint $table)
        {
            $table->dropForeign('skillcategories_ibfk_1');
        });
    }

}
