<?php namespace Projammer\Models;

use Projammer\Traits\ValidatableTrait, View, ReflectionClass;

class ProjammerModel extends \Eloquent {
	use ValidatableTrait;
	
	protected $messages = [];
	protected static $componentViewPath;

	public static function getEditor(ProjammerModel $existingObject=null) {
		return View::make(static::$componentViewPath.".editor", [strtolower(self::_prepareClassName())=>$existingObject]);
	}

	private static function _prepareClassName() {
		return (new ReflectionClass(get_called_class()))->getShortName();
	}

}