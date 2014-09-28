<?php namespace Projammer\Controllers;
use Projammer\Controllers\ProjammerController;
use \View;
use \Input;
use \Session;
use \Auth;
use \Redirect;

class AuthController extends ProjammerController {


	public function login() {
		if (Auth::check()) return Redirect::to("/project");
		if (Auth::attempt(array("email"=>Input::get("email"),"password"=>Input::get("password")))) {
			return Redirect::to("/project");
		} else {
			return Redirect::to("/login")->with("message", "Your email address and password could not be used to log you in");
		}
	}

	public function logout() {
		Auth::logout();
		return Redirect::to("/login")->with("message", "You have been logged out");
	}

}