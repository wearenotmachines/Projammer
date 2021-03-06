<?php namespace App\Projammer\Models;

class Developer extends ProjammerModel {
	
	protected $table = "developers";
	protected $fillable = ["user_id", "email", "name"];
	protected $validation = [
		"email" => 'required|email|unique:developers,email,:id',
		"name" => "required"
	];

	public function user() {
		return $this->belongsTo("App\Projammer\Models\ProjammerUser", "user_id", "id");
	}

}