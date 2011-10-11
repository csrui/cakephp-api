<?php

class ApiComponent extends Object {

	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		
		// saving the controller reference for later use
		$this->controller =& $controller;
		$this->controller->autoRender = false;		
		
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}

	//called after Controller::beforeRender()
	function beforeRender(&$controller) {

		$this->controller->plugin = 'api';

	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}


	public function setResponse($code, $custom_message = null, $errors = null) {
		
		$header = $this->controller->httpCodes($code);
		// $this->controller->header('HTTP/1.0 ' . $code . ' ' . $header[$code]);
		$this->controller->set('http_code', $code);
		
		if (is_null($custom_message)) {
			$custom_message = $header[$code];
		}
		
		$this->controller->Session->setFlash($custom_message);
		$this->controller->set('errors', $errors);
		
		$this->controller->render($this->controller->action, 'default', '/stub');
		
	}

}
?>