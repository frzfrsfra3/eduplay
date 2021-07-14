<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedDescriptionFrAndDescriptionArToSkilCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skillcategories', function (Blueprint $table) {
            $table->text('description_Fr', 65535)->nullable()->after('skill_category_decsription');
            $table->text('description_Ar', 65535)->nullable()->after('description_Fr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skillcategories', function (Blueprint $table) {
            $table->dropColumn(['description_Fr','description_Ar']);
        });
    }
}
