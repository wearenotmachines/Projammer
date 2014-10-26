<?php namespace Projammer\Controllers;

use Projammer\Models\Project;
use Projammer\Models\Client;
use Projammer\Models\Requirement;
use View, Input, Auth, Redirect, Carbon\Carbon;

class RequirementsController extends ProjammerController {
	public $layout = "layouts.standard";

	public function __construct() {
		$this->_data['title'] = "Requirements";
	}

	public function index($projectIdentifier) {
		$p = Project::with("requirements")->find($projectIdentifier);
		$this->_data = array_merge($this->_data, array("active"=>"requirements", "project"=>$p));
		$this->layout->contextNavigation = View::make("common.contextNavigation", $this->_data);
		$this->layout->currentProject = $p;
		$this->layout->jsVariables = ["project"=>$p, "requirements"=> Requirement::with(["creator", "updater"])->where("project_id", "=", $p->id)->get()];
		$this->layout->content = View::make("requirements.index", array("project"=>$p));
	}
}