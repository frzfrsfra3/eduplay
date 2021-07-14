<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 250);
			$table->string('email', 191)->unique('email');
			$table->string('provider', 500)->nullable();
			$table->string('provider_id', 500)->nullable();
			$table->string('mobile', 50)->nullable();
            $table->string('devicetype', 250)->nullable();
			$table->enum('gender', array('M','F',''))->nullable();
            $table->integer('totalpoints')->default(0);
            $table->string('aboutme', 500)->nullable();
            $table->string('password', 1000)->nullable();
			$table->string('user_image', 250)->nullable();
			$table->boolean('isactive')->default(1);
			$table->timestamp('lastloggedon');
			$table->timestamp('registeredon')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->boolean('isverified')->default(1);
			$table->integer('role_type_id')->nullable();
			$table->integer('grade_id')->nullable();
			$table->integer('school_id')->nullable()->index('school');
			$table->integer('parent_id')->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('uilanguage_id')->nullable();
			$table->date('dob')->nullable();
			$table->string('phone', 50)->nullable();
			$table->string('parentmail', 250)->nullable();
			$table->boolean('isapproved_byparent')->default(1);
            $table->string('confirmation_code', 250)->nullable();
			$table->boolean('isintroinfo_displayed')->default(0);
			$table->string('passwordtoken', 500)->nullable();
			$table->enum('registeredby', array('email','facebook','google','API' ,'registeredby' ))->default('email');
			$table->string('remember_token', 100)->nullable();
			$table->string('api_token', 60)->unique()->nullable();
			$table->enum('visit_tour', array('0','1','2'))->default('0');
			$table->enum('is_email_active', array('0','1'))->default('0');
			$table->string('verified_token', 100)->nullable();
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
		Schema::drop('users');
	}

}
