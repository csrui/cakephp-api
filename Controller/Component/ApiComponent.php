<?php

class ApiComponent extends Component {
	

	private $controller = null;
	
	public $data = array();

	//called before Controller::beforeFilter()
	public function initialize($controller) {
		
		// saving the controller reference for later use
		$this->controller = $controller;
		
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

		// $this->controller->layout = 'Api.default';
		// $this->controller->autoRender = false;
		$this->controller->viewClass = 'Api.Api';
		
		$header = $this->controller->httpCodes($code);
		// $this->controller->header('HTTP/1.0 ' . $code . ' ' . $header[$code]);
		$this->controller->set('http_code', $code);
		
		if (is_null($custom_message)) {
			$custom_message = $header[$code];
		}
		
		$this->controller->set('msg', $custom_message);
		$this->controller->set('errors', $errors);
		
		// $this->controller->render('/Api/Elements/json'); //$this->controller->action, 'Api.default', '/stub');
		
	}

}
?>