<?php namespace App\Projammer\Models;

class Role extends ProjammerModel {
	
	protected $table = "roles";
	protected $fillable = ["label", "created_by"];

}