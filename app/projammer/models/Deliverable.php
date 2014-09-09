<?php namespace App\Projammer\Models;

use App\Projammer\Models\Project;
use App\Projammer\Models\Phase;
use App\Projammer\Models\Option;

class Deliverable extends ProjammerModel {
	
	protected $table = "deliverables";

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function phase() {
		return $this->belongsTo("App\Projammer\Models\Phase");
	}

	public function options() {
		return $this->belongsToMany("App\Projammer\Models\Option");
	}

	public function artefacts() {
		return $this->morphToMany("App\Projammer\Models\Artefact", "artefactable");
	}

	public function requirements() {
		return $this->hasMany("App\Projammer\Models\Requirement");
	}

}