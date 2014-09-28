<?php namespace Projammer\Traits;

trait ValidatableTrait {

	protected $errors = [];
	protected $invalid = [];

	public function isValid() {
		self::_reconcileValidationIDs($this);
		$validator = \Validator::make($this->attributes, $this->validation);
		if ($validator->fails()) {
			$this->errors = $validator->messages();
			$this->invalid = $validator->failed();
			return false;
		} else {
			$this->errors = [];
			$this->invalid = [];
			return true;
		}
	}

	private static function _reconcileValidationIDs($object) {
		foreach ($object->validation AS &$rule) {
			$rule = preg_replace("/:id/", $object->id, $rule);
		}
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getInvalidFields() {
		return $this->invalid;
	}

}