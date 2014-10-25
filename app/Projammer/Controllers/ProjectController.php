<?php namespace Projammer\Controllers;

use Projammer\Models\Project;
use Projammer\Models\Client;
use View, Input, Auth, Redirect;

class ProjectController extends ProjammerController {

	public $layout = "layouts.standard";

	public function __construct() {
		$this->_data['title'] = "Projects";
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()	{
		$this->_data['projectStatuses'] = array_combine(Project::getProjectStatuses(), array_map(function($element) { return ucfirst($element); }, Project::getProjectStatuses()));
		$this->_data['projectEditor'] = Project::getEditor(Project::first());
		$this->layout->content = View::make("projects.index", $this->_data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$this->_data['clients'] = Client::all()->lists("name", "id");
		$this->_data['projectStatuses'] = array_combine(Project::getProjectStatuses(), array_map(function($element) { return ucfirst($element); }, Project::getProjectStatuses()));
		$this->layout->content = View::make("projects.create", $this->_data)->nest("contextNavigation", "common.contextNavigation", array("active"=>"definition"));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{
		$p = new Project(Input::get("project"));
		$p->created_by = Auth::user()->id;
		if ($p->isValid()) {
			$p->save();
			return Redirect::to("/project/".$p->id);
		} else {
			return Redirect::to("/project/create")->withInput()->withErrors($p->getValidator());
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$this->layout = null;
		$p = Project::find($id);
		echo $p;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$p = Project::find($id);
		$p->last_updated_by = Auth::user()->id;
		foreach (Input::get("project") AS $k=>$v) {
			$p->{$k} = $v;
		}
		$p->save();
		$p->updater;
		return $p;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	public function listing() {
		$output = array();
		foreach (Project::orderBy("updated_at", "desc")->with("creator", "updater")->get() AS $project) {
			$project->created_at_timestamp = strtotime($project->created_at)*100;
			$project->updated_at_timestamp = strtotime($project->updated_at)*100;
			$output[] = $project;
		}
		return $output;
	}


}
