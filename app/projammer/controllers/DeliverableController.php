<?php namespace App\Projammer\Controllers;

use App\Projammer\Models\Project;
use App\Projammer\Models\Deliverable;
use \View;
use \Input;
use \Session;

class DeliverableController extends ProjammerController {
	
	public $layout = "layouts.standard";

	public function estimate($identifier) {

		$this->_data['project'] = Project::where("id", "=", $identifier)->first();
		$this->_data['deliverables'] = Deliverable::where("project_id", "=", $identifier)->orderBy("display_order")->get();
		$this->layout->content = View::make("deliverables.estimate", $this->_data);
		$this->layout->project = $this->_data['project'];

	}

	public function update($identifier) {
		$this->layout = null;
		$deliverableData = current(Input::get("deliverable"));
		$deliverable = Deliverable::find($identifier);
		if (!array_key_exists("required", $deliverableData)) $deliverableData['required'] = 0;
		foreach ($deliverableData AS $field=>$value) {
			$deliverable->{$field} = $value;
			$deliverable->save();
		}
		return json_encode(array("status"=>1));
	}

	public function saveAll($projectID) {
		$this->layout = null;
		foreach (Input::get("deliverable") AS $id=>$data) {
			$d = Deliverable::find($id);
			if (empty($d)) $d = new Deliverable();
			foreach ($data AS $k=>$v) {
				$d->{$k} = $v;
			}
			if (!array_key_exists("required", $data)) $d->required = 0;
			$d->save();
		}
		echo json_encode(Input::get("deliverable"));
	}
}
