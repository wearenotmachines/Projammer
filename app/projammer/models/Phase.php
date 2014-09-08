<?php namespace App\Projammer\Models;

class Phase extends ProjammerModel {
	
	protected $table = "phases";

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

}