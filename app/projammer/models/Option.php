<?php namespace App\Projammer\Models;

use App\Projammer\Models\Project;
use App\Projammer\Models\Deliverable;

class Option extends ProjammerModel {
	
	protected $table = "options";
	public $timestamps = false;

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function deliverables() {
		return $this->belongsToMany("App\Projammer\Models\Deliverable");
	}

}