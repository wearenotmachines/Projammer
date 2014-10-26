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
		$this->_method = "store";
		$r = new Requirement(Input::get("requirement"));
		$r->created_by = Auth::user()->id;
		$r->save();
		$this->_payload = [ "requirement"=>$r ];
		return $this->_output();
	}	

	public function edit($identifier) {

	}

	public function update($identifier) {
		$this->_method = "update";
		$r = Requirement::find($identifier);
		foreach (Input::get("requirement") AS $k=>$v) {
			$r->{$k} = $v;
		}
		$r->save();
		$this->_payload = [ "requirement"=>$r ];
		return $this->_output();
	}

	public function destroy($identifier) {
		$this->_method = "destroy";
		$r = Requirement::find($identifier);
		$this->_messages[] = "The ".str_limit($r->name, 50, "...")." has been deleted";
		$r->delete();
		return $this->_output();
	}

}