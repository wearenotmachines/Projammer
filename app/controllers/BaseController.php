<?php

class BaseController extends Controller {

	protected $_data = [
		"title"=>""
	];

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout, $this->_data);
		}
	}

}
