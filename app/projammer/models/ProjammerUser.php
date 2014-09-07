<?php namespace App\Projammer\Models;

use App\Projammer\Traits\ValidatableTrait;

class ProjammerUser extends \User {

	use ValidatableTrait;

	protected $table = 'users';
	protected $fillable = ["email", "display_name", "password"];
	protected $validation = [
		"email" => 'required|email|unique:users,email,:id',
		"display_name" => "required"
	];
	protected $messages = [];

	public function developer() {
		return $this->hasOne("App\Projammer\Models\Developer", "user_id");
	}

	public function inspect() {
		return $this->attributes;
	}

	public function getMessages() {
		return $thîs->messages;
	}

}