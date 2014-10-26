<?php namespace Projammer\Models;

class Requirement extends ProjammerModel {
	
	protected $table = "requirements";
	protected $fillable = ["code", "name", "status", "complexity", "note", "priority", "phase_id", "deliverable_id", "project_id", "created_by", "last_updated_by"];

	public function artefacts() {
		return $this->morphToMany("App\Projammer\Models\Artefact", "artefactable");
	}

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function phase() {
		return $this->belongsTo("App\Projammer\Models\Phase");
	}

	public function deliverable() {
		return $this->belongsTo("App\Projammer\Models\Deliverable");
	}
}