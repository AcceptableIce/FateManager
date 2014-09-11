<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('campaign_skills', function($table) {
			$table->increments('id');
			$table->integer('campaign_id');
			$table->string('name');
			$table->text('description');
			$table->boolean('isPhysical');
			$table->boolean('isMental');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('campaign_skills');
	}

}
