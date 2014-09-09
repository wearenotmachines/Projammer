<?php namespace App\Projammer\Models;

class Requirement extends ProjammerModel {
	
	protected $table = "requirements";

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