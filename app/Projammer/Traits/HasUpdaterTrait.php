<?php namespace Projammer\Traits;

trait HasUpdaterTrait {
	
	public function updater() {
		return $this->belongsTo("Projammer\Models\ProjammerUser", "last_updated_by");
	}

}