<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverableOptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("options", function($table) {
			$table->increments("id");
			$table->integer("project_id")->unsigned();
			$table->string("label");
			$table->text("description")->nullable();
			$table->integer("display_order")->unsigned()->default(0);
			$table->boolean("recommended")->default(0);
			$table->foreign("project_id")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
		});
		Schema::create('deliverable_option', function(Blueprint $table)
		{
			$table->integer("option_id")->unsigned();
			$table->integer("deliverable_id")->unsigned();
			$table->primary(["option_id", "deliverable_id"], "pk_deliverable_option");
			$table->foreign("option_id", "fk_deliverable_option_option")->references("id")->on("options")->onUpdate("cascade")->onDelete("cascade");
			$table->foreign("deliverable_id", "fk_deliverable_option_deliverable")->references("id")->on("deliverables")->onUpdate("cascade")->onDelete("cascade");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("options");
		Schema::dropIfExists('deliverable_option');
	}

}
