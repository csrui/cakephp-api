<?php

class ApiComponent extends Component {
	

	private $controller = null;
	
	public $data = array();

	//called before Controller::beforeFilter()
	// public function initialize($controller) {
	// 	
	// 	// saving the controller reference for later use
	// 	$this->controller = $controller;
	// 	
	// }

	//called after Controller::beforeFilter()
	public function startup(&$controller) {	
		
		$this->controller = $controller;	
		
		# Ignore Auth functions
		if (isset($controller->Auth)) {
			if (Router::url($controller->Auth->loginAction) == Router::url()) return false;	
		}

		# Translate CakePHP POST's and regular POST's 
		if (empty($this->data) && !empty($_POST)) {
			if (isset($_POST[$this->controller->modelClass]) && is_array($_POST[$this->controller->modelClass])) {

				$this->data = $_POST;

			} else {
				
				$this->data[$this->controller->modelClass] = array();
				
				foreach($_POST as $param => $val) {
					if (strlen($val) == 0) continue;
					$this->data[$this->controller->modelClass][$param] = $val;
				}
			}
			
			# CLEARS DATA IF ARRAY IS EMPTY
			if (empty($this->data[$this->controller->modelClass])) unset($this->data[$this->controller->modelClass]);
			
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
		
		header('Access-Control-Allow-Origin: *');
		
		// $this->controller->render('/Api/Elements/json'); //$this->controller->action, 'Api.default', '/stub');
		
	}

}
?>