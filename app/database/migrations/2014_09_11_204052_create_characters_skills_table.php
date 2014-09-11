<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersSkillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('character_skills', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('character_id');
			$table->integer('skill_id');
			$table->smallInteger('rank');
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
		Schema::drop('character_skills');
	}

}
