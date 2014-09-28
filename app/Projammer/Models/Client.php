<?php namespace Projammer\Models;

class Client extends ProjammerModel {
	
	protected $table = "clients";
	protected $fillable = ["name", "external_id"];
	protected $validation = [
		"name" => "required|unique:clients,name,:id"
	];

	public function project() {
		return $this->belongsTo("App\Projammer\Models\Project");
	}

	public function humans() {
		return $this->hasMany("App\Projammer\Models\Human");
	}

}