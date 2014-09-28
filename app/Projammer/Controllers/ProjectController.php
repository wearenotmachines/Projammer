<?php namespace Projammer\Controllers;

use Projammer\Models\Project;
use View;
use Input;

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
		$this->_data['projects'] = Project::all();
		$this->_data['projectStatuses'] = Project::getProjectStatuses();
		$this->layout->content = View::make("projects.index", $this->_data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$this->layout->content = View::make("projects.create", $this->_data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
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
		foreach (Input::get("project") AS $k=>$v) {
			$p->{$k} = $v;
		}
		$p->save();
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


}
