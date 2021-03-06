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

	/**
	 * Gets a listing of all projects  - output is in the "projects" key of the JSON
	 * @param  array  $params Received params - normalized to [ num => int (>=0), offset => int (>=0) ]
	 * @return \Illuminate\Http\JsonResponse        An APIController response with a 'project's key containing project listings
	 */
	public function index() {
		$this->_method = "index";
		$params = Input::all();
		if ($this->_checkParams($this->_params=$params, $this->_method)) {
			$this->_payload = ["projects"=>Project::with(["creator", "updater"])->skip($this->_params["offset"])->take($this->_params["num"])->get()];
		}
		return $this->_output();
	}

	public function create() {}

	/**
	 * Stores an instance of Projammer\Project contsructed from POST['project'];
	 * Defaults creator to the current user
	 * @todo  Require Auth
	 * @return \Illuminate\Http\JsonResponse 	An APIController response containing the newly generated Project instance in a 'project' key
	 */
	public function store() {
		$this->_method = "store";
		$project = new Project(Input::get("project"));
		$project->created_by = Auth::user()->id;
		$project->last_updated_by = Auth::user()->id;
		$project->client_id = 1;
		if ($project->isValid()) {
			$project->save();
			$project->load(["creator", "updater"]);
		} else {
			$this->_makeErrorMessage($project->getErrors());
		}
		$this->_payload["project"] = $project;
		return $this->_output();
	}

	/**
	 * A single instance of the Project located by $identifier
	 * @param  string | int $identifier Either the slug for or id of a project
	 * @todo  Add slugifier trait
	 * @return \Illuminate\Http\JsonResponse             An APIController response a 'project' key listing the matched object
	 */
	public function show($identifier) {
		$this->_method = "show";
		$project = Project::with("creator")->where("id", "=", $identifier)->orWhere("name", "=", $identifier)->first();
		$this->_payload = array("project"=>$project);
		return $this->_output();
	}

	/**
	 * Gets an instance of Project for editing
	 * @param  string | int $identifier Either the slug for or id of a project
	 * @return \Illuminate\Http\JsonResponse             An APIController response a 'project' key listing the matched object
	 */
	public function edit($identifier) {
		$this->_method = "edit";
		$project = Project::with("creator")->where("id", "=", $identifier)->orWhere("name", "=", $identifier)->first();
		$this->_payload = array("project"=>$project);
		return $this->_jsonResponse();
	}

	public function update($identifier) {
		$this->_method = "update";
		$project = Project::find($identifier);
		$project->name = Input::get("project.name");
		$project->description = Input::get("project.description");
		$project->status = Input::get("project.status");
		$project->last_updated_by = Auth::user()->id;
		$project->touch();
		$project->save();
		$project->load("updater");
		$this->_payload = array("project"=>$project);
		return $this->_output();
	}

	public function destroy($identifier) {
		$this->_method = "destroy";
		$project = Project::find($identifier);
		$this->_messages[] = "Project: ".$project->name." has been deleted";
		$project->delete();
		return $this->_output();
	}

	
}