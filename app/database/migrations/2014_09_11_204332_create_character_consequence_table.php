<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterConsequenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('character_consequences', function($table) {
			$table->increments('id');
			$table->integer('character_id');
			$table->string('name');
			$table->text('description');
			$table->smallInteger('severity');
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
		Schema::drop('character_consequences');
	}

}
