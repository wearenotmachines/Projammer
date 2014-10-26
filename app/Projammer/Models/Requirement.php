<?php namespace Projammer\Models;

use Projammer\Traits\HasCreatorTrait;
use Projammer\Traits\HasUpdaterTrait;
/**
 * @observedBy RequirementObserver
 */

class Requirement extends ProjammerModel {
	use HasCreatorTrait, HasUpdaterTrait;

	protected $table = "requirements";
	protected $fillable = ["code", "name", "status", "complexity", "note", "priority", "phase_id", "deliverable_id", "project_id", "created_by", "last_updated_by"];

	public static $priorities = [ "M"=>"Must have","S"=>"Should have","C"=>"Could have","W"=>"Would be nice to have"];
	public static $complexities = [ "hours", "minutes", "days", "complex", "research" ];
	public static $statuses = [ "proposed", "confirmed", "implemented", "abandoned" ];

	protected $validation = [
		"project_id"=>"required",
		"name" => "required",
		"code" => "max:8",
		"status"=>"sometimes|in:proposed,confirmed,implemented,abandoned",
		"complexity" => "sometimes|in:minutes,hours,days,complex,research",
		"priority" => "sometimes|in:M,S,C,W",
		"created_by"=>"required"
	];

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