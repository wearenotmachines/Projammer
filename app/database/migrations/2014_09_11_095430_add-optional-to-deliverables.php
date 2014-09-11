<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionalToDeliverables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("deliverables", function($table) {
			$table->boolean("required")->default(1)->after("status");
			$table->integer("display_order")->default(1000)->after("id")->unsigned();
			$table->index(["project_id", "required"], "i_required_deliverable");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("deliverables", function($table) {
			$table->dropColumn("required");
			$table->dropColumn("display_order");
			$table->dropIndex("i_required_deliverable");
		});
	}

}
