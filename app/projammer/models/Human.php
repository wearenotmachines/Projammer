<?php namespace App\Projammer\Models;

class Human extends ProjammerModel {
	
	protected $table = "humans";
	protected $fillable = ["title, forename, surname, user_id, client_id"];

	public function client() {
		return $this->belongsTo("App\Projammer\Models\Client");
	}

	public function user() {
		return $this->belongsTo("App\Projammer\Models\ProjammerUser");
	}


}