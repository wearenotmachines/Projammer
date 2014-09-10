<?php namespace App\Projammer\Traits;

trait HasCreatorTrait {
	
	public function creator() {
		return $this->belongsTo("App\Projammer\Models\ProjammerUser", "created_by");
	}

}