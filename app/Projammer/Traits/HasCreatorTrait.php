<?php namespace Projammer\Traits;

trait HasCreatorTrait {
	
	public function creator() {
		return $this->belongsTo("Projammer\Models\ProjammerUser", "created_by");
	}

}