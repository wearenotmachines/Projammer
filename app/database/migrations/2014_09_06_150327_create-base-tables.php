<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
		Schema::dropIfExists("projects");
		Schema::dropIfExists("clients");
		Schema::dropIfExists("developers");
		Schema::dropIfExists("tags");
		Schema::dropIfExists("taggables");
		Schema::dropIfExists("milestones");
		Schema::dropIfExists("milestonables");
		Schema::dropIfExists("requirements");
		Schema::dropIfExists("developerables");
		Schema::dropIfExists("phases");
		Schema::dropIfExists("quotes");
		Schema::dropIfExists("quotables");
		Schema::dropIfExists("iterations");
		Schema::dropIfExists("iterationables");
		Schema::dropIfExists("proposals");
		Schema::dropIfExists("proposables");
		Schema::dropIfExists("notes");
		Schema::dropIfExists("notables");
		Schema::dropIfExists("deliverables");


		Schema::create("tags", function($table) {
			$table->increments("id");
			$table->string("tag")->unique();
			$table->index("tag");
		});


		Schema::create("clients", function($table) {
			$table->integer("id")->unsigned();
			$table->primary("id");
			$table->string("name");
			$table->morphs("taggable");
			$table->morphs("notable");
		});
		
		Schema::create("developers", function($table) {
			$table->increments("id");
			$table->string("name");
			$table->string("email")->unique();
			$table->boolean("active")->default(true);
			$table->softDeletes();
		});

		Schema::create("projects", function($table) {
			$table->increments("id");
			$table->string("name");
			$table->text("description")->nullable();
			$table->integer("client_id")->unsigned();
			$table->integer("created_by")->unsigned();
			$table->enum("status", ["presales", "planning", "development", "uat", "beta", "live", "snagging", "archived", "cancelled"]);
			$table->dateTime("closed");
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("created_by")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
			$table->foreign('client_id')->references('id')->on("clients")->onUpdate("cascade")->onDelete("restrict");
			$table->index("client_id");
			$table->index("created_by");
			$table->index("status");
		});

		Schema::create("deliverables", function($table) {
			$table->increments("id");
			$table->string("name", 512);
			$table->text("description")->nullable();
			$table->text("note")->nullable();
			$table->enum("status", ["specified", "modelled", "prototyped", "tested", "released", "snagging"])->default("specified");
			$table->enum("complexity", ["minutes", "hours", "days", "weeks", "months"])->default("hours");
			$table->decimal("development_cost", 8, 2)->default(0.00);
			$table->decimal("development_time", 8, 2)->default(0.00);
			$table->integer("project_id")->unsigned();
			$table->integer("created_by")->unsigned();
			$table->integer("phase_id")->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("project_id", "fk_deliverables_project")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->index("project_id", "i_deliverables_project");
			$table->foreign("created_by", "fk_deliverables_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
			$table->index(["project_id","phase_id"], "i_deliverables_phase");
			$table->foreign("phase_id", "fk_deliverables_phase")->references("id")->on("phases")->onUpdate("cascade")->onDelete("set null");
		});
		
		Schema::create("phases", function($table) {
			$table->increments("id");
			$table->string("code")->nullable();
			$table->integer("project_id")->unsigned();
			$table->text("description")->nullable();
			$table->date("starts")->nullable();
			$table->date("ends")->nullable();
			$table->integer("created_by")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index("project_id", "i_phases_project");
			$table->foreign("created_by")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});

		Schema::create("requirements", function($table) {
			$table->increments("id");
			$table->integer("project_id")->unsigned();
			$table->string("code")->nullable();
			$table->string("name", 512);
			$table->enum("status", ["proposed", "confirmed", "implemented", "abandoned"])->nullable()->default("proposed");
			$table->enum("complexity", ["minutes", "hours", "days", "complex", "research"])->nullable()->default("hours");
			$table->text("note")->nullable();
			$table->enum("priority", ["M", "S", "C", "W"])->nullable();
			$table->integer("phase_id")->unsigned()->nullable();
			$table->integer("deliverable_id")->unsigned()->nullable();
			$table->integer("created_by")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("project_id")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->foreign("phase_id")->references("id")->on("phases")->onUpdate("cascade")->onDelete("set null");
			$table->foreign("deliverable_id")->references("id")->on("deliverables")->onUpdate("cascade")->onDelete("set null");
			$table->foreign("created_by")->references("id")->on("developers")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["project_id", "code"], "i_requirements_code");
			$table->index(["project_id", "priority"], "i_requirements_priority");
			$table->index(["project_id", "phase_id"], "i_requirements_phase");
			$table->index("deliverable_id");
		});

		Schema::create("milestones", function($table) {
			$table->increments("id");
			$table->string("name");
			$table->enum("status", ["proposed", "confirmed", "met", "missed"])->default("proposed");
			$table->integer("created_by")->unsigned();
			$table->integer("project_id")->unsigned();
			$table->integer("phase_id")->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("created_by", "fk_milestone_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
			$table->foreign("project_id", "fk_milestone_project")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->foreign("phase_id", "fk_milestone_phase")->references("id")->on("phases")->onUpdate("cascade")->onDelete("set null");
			$table->index(["project_id", "phase_id"], "i_milestones_project_phase");
		});

		Schema::create("quotes", function($table) {
			$table->increments("id");
			$table->string("title");
			$table->text("description")->nullable();
			$table->integer("external_id")->unsigned()->nullable();
			$table->integer("proposal_id")->unsigned()->nullable();
			$table->decimal("totalCost", 10, 2)->default(0.00);
			$table->decimal("totalTime", 10, 2)->default(0.00);
			$table->enum("status", ["unsent", "sent", "approved", "invoiced", "paid", "rejected"])->default("unsent");
			$table->integer("created_by")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index("external_id", "i_quote_external");
			$table->foreign("proposal_id", "pk_quotes_proposal")->references("id")->on("proposals")->onUpdate("cascade")->onDelete("set null");
			$table->foreign("created_by", "fk_quote_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");

		});

		Schema::create("iterations", function($table) {
			$table->increments("id");
			$table->integer("sequence")->unsigned();
			$table->integer("project_id")->unsigned();
			$table->integer("created_by")->unsigned();
			$table->date("starts");
			$table->date("ends");
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("project_id", "pk_iterations_project")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["project_id", "sequence"], "i_iteration_sequence");
			$table->foreign("created_by", "fk_iteration_creator")->references("id")->on("developers")->onUpdate("cascade")->onDelete("restrict");
		});

		Schema::create("notes", function($table) {
			$table->increments("id");
			$table->text("content");
			$table->timestamps();
			$table->integer("created_by")->unsigned();
			$table->foreign("created_by")->references("id")->on("developer")->onUpdate("cascade")->onDelete("restrict");
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

		Schema::create("milestonables", function($table) {
			$table->integer("milestone_id")->unsigned();
			$table->integer("milestonable_id")->unsigned();
			$table->string("milestonable_type");
			$table->primary(["milestone_id", "milestonable_id", "milestonable_type"], "pk_milestonables");
			$table->foreign("milestone_id")->references("id")->on("milestones")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["milestonable_type", "milestonable_id"], "i_milestonable");
			$table->index("milestone_id");
		});

		Schema::create("taggables", function($table) {
			$table->integer("taggable_id")->unsigned();
			$table->string("taggable_type");
			$table->integer("tag_id")->unsigned();
			$table->foreign("tag_id")->references("id")->on("tags")->onUpdate("cascade")->onDelete("cascade");
			$table->index("tag_id");
			$table->index(["taggable_id", "taggable_type"]);
			$table->primary(["tag_id", "taggable_id", "taggable_type"], "pk_taggables");
		});

		Schema::create("quotables", function($table) {
			$table->integer("quotable_id")->unsigned();
			$table->string("quotable_type");
			$table->integer("quote_id")->unsigned();
			$table->integer("display_order")->unsigned()->default(99999);
			$table->primary(["quote_id", "quotable_id", "quotable_type"], "pk_quotables");
			$table->foreign("quote_id", "fk_quotables_quote")->references("id")->on("quotes")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["quotable_id", "quotable_type"], "i_quotable");
		});

		Schema::create("notables", function($table) {
			$table->integer("note_id")->unsigned();
			$table->integer("notable_id")->unsigned();
			$table->string("notable_type");
			$table->primary(["note_id", "notable_id", "notable_type"], "pk_notable");
			$table->foreign("note_id")->references("id")->on("notes")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["notable_id", "notable_type"], "i_notable");
		});

		Schema::create("proposables", function($table) {
			$table->integer("proposal_id")->unsigned();
			$table->integer("proposable_id")->unsigned();
			$table->string("proposable_type");
			$table->primary(["proposal_id", "proposable_id", "proposable_type"], "pk_proposable");
			$table->index(["proposable_id", "proposable_type"],"i_proposable");
			$table->foreign("proposal_id", "fk_proposable_proposal")->references("id")->on("proposal")->onUpdate("cascade")->onDelete("cascade");
		});

		Schema::create("iterationables", function($table) {
			$table->integer("iteration_id")->unsigned();
			$table->integer("iterationable_id")->unsigned();
			$table->string("iterationable_type");
			$table->primary(["iteration_id", "iterationable_id", "iterationable_type"], "pk_iterationable");
			$table->foreign("iteration_id", "fk_iterationable_iteration")->references("id")->on("iterations")->onUpdate("cascade")->onDelete("cascade");
			$table->index(["iterationable_id", "iterationable_type"], "i_iterationable");
		});

		DB::statement("SET FOREIGN_KEY_CHECKS = 1;");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
		Schema::dropIfExists("projects");
		Schema::dropIfExists("clients");
		Schema::dropIfExists("developers");
		Schema::dropIfExists("tags");
		Schema::dropIfExists("taggables");
		Schema::dropIfExists("milestones");
		Schema::dropIfExists("milestonables");
		Schema::dropIfExists("requirements");
		Schema::dropIfExists("developerables");
		Schema::dropIfExists("phases");
		Schema::dropIfExists("quotes");
		Schema::dropIfExists("quotables");
		Schema::dropIfExists("iterations");
		Schema::dropIfExists("iterationables");
		Schema::dropIfExists("proposals");
		Schema::dropIfExists("proposables");
		Schema::dropIfExists("notes");
		Schema::dropIfExists("notables");
		Schema::dropIfExists("deliverables");
		DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
	}

}
