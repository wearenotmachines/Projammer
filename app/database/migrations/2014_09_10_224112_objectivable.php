<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Objectivable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("objectivables", function($table) {
			$table->morphs("objectivable");
			$table->integer("objective_id")->unsigned();
			$table->foreign("objective_id", "fk_objectivable_objective")->references("id")->on("objectives")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["objectivable_id", "objectivable_type"], "i_objectivable");
			$table->primary(["objective_id", "objectivable_id", "objectivable_type"], "pk_objectivable");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("objectivable");
	}

}
