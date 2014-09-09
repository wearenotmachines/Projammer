<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtefactsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create("artefacts", function($table) {
			$table->increments("id");
			$table->string("label", 255);
			$table->text("description")->nullable();
			$table->string("filename", 512);
			$table->integer("filesize")->unsigned();
			$table->string("filetype");
			$table->integer("created_by")->unsigned();
			$table->integer("last_updated_by")->unsigned()->nullable();
			$table->integer("project_id")->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign("created_by", "fk_artefact_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
			$table->foreign("last_updated_by", "fk_artefact_updater")->references("id")->on("users")->onUpdate("cascade")->onDelete("set null");
			$table->index("project_id", "i_artefact_project");
			$table->foreign("project_id")->references("id")->on("projects")->onUpdate("cascade")->onDelete("cascade");
		});

		Schema::create("artefactables", function($table) {
			$table->integer("artefact_id")->unsigned();
			$table->integer("artefactable_id")->unsigned();
			$table->string("artefactable_type");
			$table->foreign("artefact_id", "fk_artefactable_artefact")->references("id")->on("artefacts")->onUpdate("cascade")->onDelete("cascade");
			$table->primary(["artefact_id", "artefactable_id", "artefactable_type"], "pk_artefactable");
			$table->index(["artefactable_id", "artefactable_type"], "i_artefactable");
		});

		DB::statement("ALTER TABLE artefacts ADD FULLTEXT INDEX ft_artefacts (label, description)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists("artefacts");
		Schema::dropIfExists("artefactables");
	}

}
