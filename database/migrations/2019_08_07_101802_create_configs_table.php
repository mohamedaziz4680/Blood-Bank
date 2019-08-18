<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigsTable extends Migration {

	public function up()
	{
		Schema::create('configs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('about');
			$table->string('phone');
			$table->string('email');
			$table->string('facebook_url');
			$table->string('twitter_url');
			$table->string('youtube_url');
			$table->string('instagram_url');
			$table->string('whatsapp_url');
			$table->string('google_plus_url');
			$table->string('image');
		});
	}

	public function down()
	{
		Schema::drop('configs');
	}
}