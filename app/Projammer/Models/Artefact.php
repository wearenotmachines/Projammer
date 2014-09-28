<?php namespace App\Projammer\Models;

class Artefact extends ProjammerModel {
	
	protected $table = "artefacts";
	protected $fillable = ["label", "description", "project_id", "filetype", "filesize", "filename", "created_by", "last_updated_by"];

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function deliverables() {
		return $this->morphedByMany("App\Projammer\Models\Deliverable", "artefactable");
	}

	public function requirements() {
		return $this->morphedByMany("App\Projammer\Models\Requirement", "artefactable");
	}
}