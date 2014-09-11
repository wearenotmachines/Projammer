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
	$u = App\Projammer\Models\ProjammerUser::find(1);
	$d = $u->developer;

	echo $d->user;
});

Route::get("/loginAlex", function() {
	$u = App\Projammer\Models\ProjammerUser::where("email", "=", "alex.callard@itrm.co.uk")->first();
	Auth::login($u);
	echo Auth::user();
});

Route::get("/whoami", function() {
	echo Auth::user();
});

Route::resource("project", "App\Projammer\Controllers\ProjectController");

Route::get("/project/{identifier}/estimate", "App\Projammer\Controllers\DeliverableController@estimate");
