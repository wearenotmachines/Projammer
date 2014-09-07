<?php namespace App\Projammer\Models;

use App\Projammer\Traits\ValidatableTrait;

class ProjammerModel extends \Eloquent {
	use ValidatableTrait;
	
	protected $messages = [];


}