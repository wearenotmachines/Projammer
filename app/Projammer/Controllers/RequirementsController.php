<?php namespace Projammer\Controllers;

use Projammer\Models\Project;
use Projammer\Models\Client;
use View, Input, Auth, Redirect, Carbon\Carbon;

class RequirementsController extends ProjammerController {
	public $layout = "layouts.standard";

	public function __construct() {
		$this->_data['title'] = "Requirements";
	}

	public function index($projectIdentifier) {
		$p = Project::with("requirements")->find($projectIdentifier);
		$this->layout->contextNavigation = View::make("common.contextNavigation", array("active"=>"requirements", "project"=>$p));
		$this->layout->currentProject = $p;
		$this->layout->content = View::make("requirements.index", array("project"=>$p));
	}
}