<?php namespace Projammer\Controllers\API;
use Projammer\Models\Project, Input, Auth, Projammer\Models\Requirement;
class RequirementAPIController extends APIController {

	protected $_paramValidation = [
		"index"=>[
			"num"=>"integer|min:0",
			"offset"=>"integer|min:0",
			"project"=>"required"
		]
	];
	
	protected $_defaultParams = [
		"index"=>[
			"num"=>20,
			"offset"=>0
		]
	];

	public function index() {
		$this->_method = "index";
		$params = Input::all();
		if ($this->_checkParams($this->_params=$params, $this->_method)) {
			$this->_payload = [
				"project"=>Project::find($this->_params['project']),
				"requirements"=>Requirement::with(["creator", "updater"])
											->where("project_id", "=", $this->_params['project'])
											->take($this->_params['num'])
											->skip($this->_params['offset'])
											->get()
			];
		}
		return $this->_output();
	}

	public function show($identifier) {

	}

	public function create() {

	}

	public function store() {
	
	}	

	public function edit($identifier) {

	}

	public function update($identifier) {

	}

	public function destroy($identifier) {

	}

}