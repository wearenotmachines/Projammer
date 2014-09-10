<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwapDevelopersForHumans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		DB::statement("SET FOREIGN_KEY_CHECKS = 0");

		Schema::dropIfExists("developerables");
		Schema::dropIfExists("developers");
		Schema::table("projects", function($table) {
			$table->dropForeign("projects_created_by_foreign");
			$table->foreign("created_by", "fk_project_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("deliverables", function($table) {
			$table->dropForeign("fk_deliverables_creator");
			$table->foreign("created_by", "fk_deliverable_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("iterations", function($table) {
			$table->dropForeign("fk_iteration_creator");
			$table->foreign("created_by", "fk_iteration_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("milestones", function($table) {
			$table->dropForeign("fk_milestone_creator");
			$table->foreign("created_by", "fk_milestone_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("phases", function($table) {
			$table->dropForeign("phases_created_by_foreign");
			$table->foreign("created_by", "fk_phase_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});		
		Schema::table("quotes", function($table) {
			$table->dropForeign("fk_quote_creator");
			$table->foreign("created_by", "fk_quote_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("requirements", function($table) {
			$table->dropForeign("requirements_created_by_foreign");
			$table->foreign("created_by", "fk_requirement_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});

		DB::statement("SET FOREIGN_KEY_CHECKS = 1");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::table("projects", function() {
			$table->foreign("created_by")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});

		Schema::create("developers", function($table) {
			$table->increments("id");
			$table->string("name");
			$table->string("email")->unique();
			$table->boolean("active")->default(true);
			$table->softDeletes();
		});

		//Morph Tables
    	Schema::create("developerables", function($table) {
   			$table->integer("developer_id")->unsigned();
   			$table->string("developable_type");
   			$table->integer("developable_id")->unsigned();
   			$table->foreign("developer_id")->references("id")->on("developers")->onUpdate("cascade")->onDelete("cascade");
   			$table->index("developer_id");
   			$table->index(["developable_id", "developable_type"], "i_developable");
   			$table->primary(["developer_id", "developable_id", "developable_type"], "pk_developerables");
    	});

    	Schema::table("projects", function($table) {
			$table->dropForeign("fk_project_creator");
			$table->foreign("created_by", "fk_project_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("deliverables", function($table) {
			$table->dropForeign("fk_deliverable_creator");
			$table->foreign("created_by", "fk_deliverable_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("iterations", function($table) {
			$table->dropForeign("fk_iteration_creator");
			$table->foreign("created_by", "fk_iteration_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("milestones", function($table) {
			$table->dropForeign("fk_milestone_creator");
			$table->foreign("created_by", "fk_milestone_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("phases", function($table) {
			$table->dropForeign("fk_phase_creator");
			$table->foreign("created_by", "fk_phase_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});		
		Schema::table("quotes", function($table) {
			$table->dropForeign("fk_quote_creator");
			$table->foreign("created_by", "fk_quote_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::table("requirements", function($table) {
			$table->dropForeign("fk_requirement_creator");
			$table->foreign("created_by", "fk_requirement_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});
	}

}
