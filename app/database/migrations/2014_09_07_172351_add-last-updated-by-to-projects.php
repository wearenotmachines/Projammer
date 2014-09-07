<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastUpdatedByToProjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("projects", function($table) {
			$table->integer("last_updated_by")->unsigned()->nullable();
			$table->foreign("last_updated_by", "fk_project_updated_by")->references("id")->on("users")->onUpdate("cascade")->onDelete("set null");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("projects", function($table) {
			$table->dropForeign("fk_project_updated_by");
			$table->dropColumn("last_updated_by");
		});
	}

}
