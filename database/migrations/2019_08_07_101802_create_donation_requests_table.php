<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('age');
			$table->integer('blood_bags');
			$table->string('hospital_name');
			$table->decimal('latitude');
			$table->decimal('longatitude');
			$table->integer('city_id')->unsigned();
			$table->string('phone_number');
			$table->string('comments')->nullable();
			$table->integer('client_id')->unsigned();
			$table->integer('blood_type_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}