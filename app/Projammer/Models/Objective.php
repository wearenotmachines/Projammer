<?php namespace App\Projammer\Models;

use App\Projammer\Traits\HasCreatorTrait;

class Objective extends ProjammerModel {

	use HasCreatorTrait;
	
	protected $table = "objectives";

	protected $fillable = ["text", "project_id", "phase_id", "created_by"];

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function phase() {
		return $this->belongsTo("App\Projammer\Models\Phase");
	}

	public function deliverables() {
		return $this->morphedByMany("App\Projammer\Models\Deliverable", "objectivable");
	}

}