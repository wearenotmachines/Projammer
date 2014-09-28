<?php namespace Projammer\Models;

use Projammer\Traits\ValidatableTrait;

class ProjammerModel extends \Eloquent {
	use ValidatableTrait;
	
	protected $messages = [];

}