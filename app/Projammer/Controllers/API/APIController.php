<?php namespace Projammer\Controllers\API;
use Projammer\Controllers\ProjammerController;
use Validator,Response,MessageBag, JsonResponse;

abstract class APIController extends ProjammerController {
	
	/**
	 * The API method that was called
	 * @var string
	 */
	protected $_method;
	/**
	 * Error messages generated
	 * @var array
	 */
	protected $_errors = array();
	/**
	 * Informational Messages generated
	 * @var array
	 */
	protected $_messages = array();
	/**
	 * HTTP status to send
	 * @var integer
	 */
	protected $_status = 200;
	/**
	 * The body of the API output this is going to be array_merge'd in the output function so use a dictionary to properly control the output
	 * @var array
	 */
	protected $_payload = array();
	/**
	 * A array of parameters - these begin as Params supplied by the user but will be validated and normalized in the arrays below
	 * @var array
	 */
	protected $_params = array();
	/**
	 * Validation rules for Parameters - a array of [ method => [ paramName => validation|rules ] ]
	 * @var array
	 */
	protected $_paramValidation = array();
	/**
	 * A array of default values for parameter groups - [ method => [ paramName => default value ] ]
	 * @var array
	 */
	protected $_defaultParams = array();

	/**
	 * Outputs a JSON Response with detailed information about the call .
	 * Output Structure:
	 * status : int (httpStatus)
	 * method : string
	 * params : array (params supplied / default values)
	 * errors : array (if any generated)
	 * messages : array (if any generated)
	 * payload : * (specified in the function that generates this output)
	 * @return \Illuminate\Http\JsonResponse A Symphony \Illuminate\Http\JsonResponse
	 */
	protected function _output() {
		$output = array_merge(array("status"=>$this->_status,"method"=>$this->_method,"params"=>$this->_params,"errors"=>$this->_errors,"messages"=>$this->_messages), $this->_payload);
		return Response::json(
				$output,
				$this->_status,
				$headers =[],
				JSON_PRETTY_PRINT);
	}

	/**
	 * Populates the _errors property from a MessageBag, sets the _status property to 500 to generate an http 500 response
	 * @param  \Illuminate\Support\MessageBag $errors A MessageBag of error messages
	 * @return *         Returns the instance - for chaining
	 */
	protected function _makeErrorMessage($errors) {
		$this->_status = 500;
		foreach ($errors->all() AS $e) {
			$this->_errors[] = $e;
		}
		return $this;
	}

/**
 * Checks the received params for validation errors - if validation rules exist for the $method supplied
 * Normalizes the params with default values from $_defaultParams if any exist for the $method supplied		
 * @param  array $receivedParams a array of parameters
 * @param  string $method         the name of the method against which to check params
 * @return boolean                params are valid or not
 */
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

	/**
	 * A listing function
	 * @param  array  $options listing output control - ie num, offset
	 * @return \Illuminate\Http\JsonResponse          A \Illuminate\Http\JsonResponse string
	 */
	abstract function index($options=array());

	/**
	 * An object creation function
	 * @return \Illuminate\Http\JsonResponse A transient instance of an Object (ie one that is not yest stored)
	 */
	abstract function create();

	/**
	 * Persists and object
	 * @return \Illuminate\Http\JsonResponse The instance that was just stored
	 */
	abstract function store();

	/**
	 * Data for a single object
	 * @param  * $identifier Value to use to identify the object
	 * @return \Illuminate\Http\JsonResponse       A response containing the JSON representation of the object requested
	 */
	abstract function show($identifier);

	/**
	 * Gets a JSON respresentation of a requested object for editing
	 * @param  * $identifier An identifier
	 * @return \Illuminate\Http\JsonResponse             A response containing the JSON representation of an object for editing
	 */
	abstract function edit($identifier);

	/**
	 * Persists an updated object
	 * @param  * $identifier The identifier used to match the object to be stored
	 * @return \Illuminate\Http\JsonResponse             A response containing the updated object
	 */
	abstract function update($identifier);

	/**
	 * Deletes an object
	 * @param  * $identifier The identifier to select the object to be destroyed
	 * @return \Illuminate\Http\JsonResponse             Json Confirmation that the object was destroyed
	 */
	abstract function destroy($identifier);
}