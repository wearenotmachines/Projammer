<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	$u = Projammer\Models\ProjammerUser::first();

	echo $u;
});

Route::get('/login', function() {
	if (Auth::check()) return Redirect::to("/project");
	return View::make("layouts.standard", array("title"=>"Log in to Projammer"))->nest("content", "auth.login");
});
Route::post("/login", "Projammer\Controllers\AuthController@login");

Route::get("/logout", "Projammer\Controllers\AuthController@logout");

Route::get("/loginAlex", function() {
	$u = Projammer\Models\ProjammerUser::where("email", "=", "alex.callard@itrm.co.uk")->first();
	Auth::login($u);
	echo Auth::user();
});

Route::get("/whoami", function() {
	echo Auth::user();
});

/**************************** PROJECT ROUTES *****************************************/

Route::resource("project", "Projammer\Controllers\ProjectController");
Route::get("/projects", "Projammer\Controllers\ProjectController@index");
Route::get("/projects/listing", "Projammer\Controllers\ProjectController@listing");

/**************************** PROJECT ROUTES END *************************************/

/**************************** REQUIREMENTS ROUTES *****************************************/

Route::get("/project/{id}/requirements", "Projammer\Controllers\RequirementsController@index");

/**************************** REQUIREMENTS ROUTES END *************************************/

/**************************** DELIVERABLES ROUTES *****************************************/

Route::get("/project/{identifier}/estimate", "App\Projammer\Controllers\DeliverableController@estimate");
Route::post("/project/{identifier}/estimate/save", "App\Projammer\Controllers\DeliverableController@saveAll");
Route::resource("deliverable", "App\Projammer\Controllers\DeliverableController");
// Route::post("/deliverable/store", "App\Projammer\Controllers\DeliverableController@store");
/**************************** DELIVERABLES ROUTES END *************************************/

/**************************** API ROUTES **********************************************/
Route::resource("api/project", "Projammer\Controllers\API\ProjectAPIController");
/**************************************************************************************/
