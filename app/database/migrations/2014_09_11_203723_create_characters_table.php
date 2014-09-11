<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('character', function($table) {
			$table->increments('id');
			$table->integer('campaign_id');
			$table->string('name');
			$table->text('description');
			$table->text('extras');
			$table->smallInteger('refresh');
			$table->smallInteger('fate_points');
			$table->smallInteger('max_physical_stress');
			$table->smallInteger('max_mental_stress');
			$table->smallInteger('physical_stress_taken');
			$table->smallInteger('mental_stress_taken');
			$table->boolean('has_extra_consequence');
			$table->boolean('visible');
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
		Schema::drop('campaign_skills');
	}

}
