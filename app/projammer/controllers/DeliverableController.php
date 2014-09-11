<?php namespace App\Projammer\Controllers;

use App\Projammer\Models\Project;
use App\Projammer\Models\Deliverable;
use \View;

class DeliverableController extends ProjammerController {
	
	public $layout = "layouts.standard";

	public function estimate($identifier) {

		$this->_data['project'] = Project::where("id", "=", $identifier)->first();
		$this->_data['deliverables'] = Deliverable::where("project_id", "=", $identifier)->orderBy("display_order")->get();
		$this->layout->content = View::make("deliverables.estimate", $this->_data);

	}

	public function update() {
		$deliverableData = Input::get("deliverable");
		echo "<pre>"; print_r($deliverableData); echo "</pre>";
	}
}
