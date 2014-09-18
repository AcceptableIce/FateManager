<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('player_requests', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('from_id');
			$table->smallInteger('type');
			$table->text('value');
			$table->boolean('seen')->default(false);
			$table->boolean('acceptable')->default(true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('campaign_requests');
	}

}
