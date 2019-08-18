<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->date('date_of_birth');
			$table->date('last_day_of_donation');
			$table->integer('city_id')->unsigned();
			$table->string('phone_number')->unique();
			$table->string('password');
			$table->integer('pin_code')->nullable();
			$table->integer('blood_type_id')->unsigned()->nullable();
			$table->string('api_token',60)->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}