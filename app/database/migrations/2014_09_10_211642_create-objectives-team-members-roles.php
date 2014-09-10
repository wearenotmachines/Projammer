<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesTeamMembersRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::dropIfExists("objectives");
		Schema::dropIfExists("roles");
		Schema::dropIfExists("humans");
		Schema::dropIfExists("team_members");

		Schema::create("objectives", function($table) {
			$table->increments("id");
			$table->text("text");
			$table->integer("project_id")->unsigned();
			$table->integer("phase_id")->unsigned()->nullable();
			$table->integer("created_by")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("project_id", "fk_objective_project")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->foreign("phase_id", "fk_objective_phase")->references("id")->on("phases")->onUpdate("cascade")->onDelete("set null");
			$table->index(["project_id", "phase_id"], "i_objective_project_phase");
			$table->foreign("created_by")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
		Schema::create("roles", function($table) {
			$table->increments("id");
			$table->string("label");
			$table->softDeletes();
		});
		Schema::create("humans", function($table) {
			$table->increments("id");
			$table->enum("title", ["Mr", "Mrs", "Ms", "Miss", "Dr"])->default("Mr");
			$table->string("forename")->nullable();
			$table->string("surname")->nullable();
			$table->text("note")->nullable();
			$table->integer("client_id")->unsigned()->nullable();
			$table->integer("user_id")->unsigned()->nullable();
			$table->integer("created_by")->unsigned();
			$table->boolean("active")->default(1);
			$table->timestamps();
			$table->foreign("user_id", "fk_humans_user")->references("id")->on("users")->onUpdate("cascade")->onDelete("set null");
			$table->foreign("created_by", "fk_humans_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
			$table->index("client_id","i_human_client");
			$table->index("user_id", "i_human_user");
		});
		Schema::create("team_members", function($table) {
			$table->increments("id");
			$table->integer("project_id")->unsigned();
			$table->integer("human_id")->unsigned();
			$table->integer("role_id")->unsigned();
			$table->foreign("project_id", "fk_team_member_project")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["project_id", "human_id", "role_id"], "i_team_members");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists("objectives");
		Schema::dropIfExists("roles");
		Schema::dropIfExists("humans");
		Schema::dropIfExists("team_members");
	}

}
