<?php namespace Projammer\Controllers\API;
use Projammer\Models\Project, Input, Auth;

class ProjectAPIController extends APIController {

	protected $_paramValidation = [
		"index"=>[
			"num"=>"integer|min:0",
			"offset"=>"integer|min:0"
		]
	];
	protected $_defaultParams = [
		"index"=>[
			"num"=>20,
			"offset"=>0
		]
	];

	public function index($params=array()) {
		$this->_method = "index";
		if ($this->_checkParams($this->_params=$params, $this->_method)) {
			$this->_payload = ["projects"=>Project::with("creator")->skip($this->_params["offset"])->take($this->_params["num"])->get()];
		}
		return $this->_output();
	}

	public function create() {}

	public function store() {
		$this->_method = "store";
		$project = new Project(Input::get("project"));
		$project->created_by = Auth::user()->id;
		$project->client_id = 1;
		if ($project->isValid()) {
			$project->save();
			$project->load("creator");
		} else {
			$this->_makeErrorMessage($project->getErrors());
		}
		$this->_payload["project"] = $project;
		return $this->_output();
	}

	public function show($identifier) {
		$project = Project::where("id", "=", $identifier)->orWhere("name", "=", $identifier)->first();
		$this->_payload = array("project"=>$project);
		return $this->_output();
	}

	public function edit($identifier) {
		$project = Project::where("id", "=", $identifier)->orWhere("name", "=", $identifier)->first();
		$this->_payload = array("project"=>$project);
		return $this->_jsonResponse();
	}

	public function update($identifier) {

	}

	public function destroy($identifier) {

	}

	
}