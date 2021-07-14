<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedPracticeTokenInPracticeresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practiceresults', function (Blueprint $table) {
            $table->string('practice_token', 250)->nullable()->after('total_minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practiceresults', function (Blueprint $table) {
            $table->dropColumn(['practice_token']);
        });
    }
}
