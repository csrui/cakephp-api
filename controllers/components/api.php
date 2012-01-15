<?php

class ApiComponent extends Object {
	
	public $data = array();

	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		
		// saving the controller reference for later use
		$this->controller =& $controller;
		
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {				
		
		# Translate CakePHP POST's and regular POST's 
		if (empty($this->data) && !empty($_POST)) {
			if (isset($_POST[$this->controller->modelNames[0]]) && is_array($_POST[$this->controller->modelNames[0]])) {

				$this->data = $_POST;

			} else {
				
				$this->data[$this->controller->modelNames[0]] = array();
					
				foreach($_POST as $param => $val) {
					if (strlen($val) == 0) continue;
					$this->data[$this->controller->modelNames[0]][$param] = $val;
				}
			}
			
			# CLEARS DATA IF ARRAY IS EMPTY
			if (empty($this->data[$this->controller->modelNames[0]])) unset($this->data[$this->controller->modelNames[0]]);
			
		}
		
	}

	//called after Controller::beforeRender()
	function beforeRender(&$controller) {


	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}
	
	public function setResponse($code, $custom_message = null, $errors = array()) {

		$this->controller->plugin = 'api';		
		$this->controller->autoRender = false;
		
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