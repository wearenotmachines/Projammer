<?php namespace Projammer\Controllers\API;
use Projammer\Controllers\ProjammerController;
use Validator,Response;

abstract class APIController extends ProjammerController {
	
	protected $_method;
	protected $_errors = array();
	protected $_messages = array();
	protected $_status = 200;
	protected $_payload;
	protected $_params = array();
	protected $_paramValidation = array();
	protected $_defaultParams = array();


	protected function _output() {
		$output = array_merge(array("status"=>$this->_status,"method"=>$this->_method,"params"=>$this->_params,"errors"=>$this->_errors,"messages"=>$this->_messages), $this->_payload);
		return Response::json(
				$output,
				$this->_status,
				$headers =[],
				JSON_PRETTY_PRINT);
	}

	protected function _makeErrorMessage($errors) {
		$this->_status = 500;
		foreach ($errors->all() AS $e) {
			$this->_errors[] = $e;
		}
		return $this;
	}

	protected function _checkParams($receivedParams, $method) {
		if (array_key_exists($method, $this->_paramValidation)) {
			$v =Validator::make($receivedParams, $this->_paramValidation[$method]);
			if ($v->fails()) {
				$this->_makeErrorMessage($v->messages());
				return false;
			}
		}	
		$this->_status = 200;
		//set default parameters if possible
		if (array_key_exists($this->_method, $this->_defaultParams)) {
			foreach (array_keys($this->_defaultParams[$this->_method]) AS $p) {
				if (!array_key_exists($p, $this->_params)) {
					$this->_params[$p] = $this->_defaultParams[$this->_method][$p];
				}
			}
		}
		return true;

	}

	abstract function index($options=array());
	abstract function create();
	abstract function store();
	abstract function show($identifier);
	abstract function edit($identifier);
	abstract function update($identifier);
	abstract function destroy($identifier);
}