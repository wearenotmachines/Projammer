<?php namespace App\Projammer\Models;
use App\Projammer\Models\Option;
use App\Projammer\Models\Client;
use App\Projammer\Models\Deliverable;

class Project extends ProjammerModel {

	protected $table = "projects";
	protected $fillable = ["name","description","start_date", "finish_date", "status", "created_by", "last_updated_by"];
	protected static $statuses = ["presales","planning","development","UAT","beta","live","snagging","archived","cancelled"];
	protected $validation = [
		"title" => "required",
		"status" => "in:presales,planning,development,uat,beta,live,snagging,archived,cancelled",
		"created_by" => "required",
		"client" => "required"
	];

	public function client() {
		return $this->hasOne("App\Projammer\Models\Client");
	}

	public static function getProjectStatuses() {
		return self::$statuses;
	}

	public function options() {
		return $this->hasMany("App\Projammer\Models\Option");
	}

	public function deliverables() {
		return $this->hasMany("App\Projammer\Models\Deliverable");
	}

	public function phases() {
		return $this->hasMany("App\Projammer\Models\Phase");
	}

	public function artefacts() {
		return $this->hasMany("App\Projammer\Models\Artefact");
	}

}