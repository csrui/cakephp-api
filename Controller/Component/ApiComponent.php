<?php

class ApiComponent extends Component {
	

	private $controller = null;
	
	public $data = array();

	//called before Controller::beforeFilter()
	public function initialize(Controller $controller) {
		
		// saving the controller reference for later use
		$this->controller = $controller;
		
	}

	//called after Controller::beforeFilter()
	public function startup(Controller $controller) {	
		
		# If not using json, just ignore
		#TODO Improve code with a conf with valid extensions
		// if (!isset($controller->request->params['ext']) || $controller->request->params['ext'] != 'json') return;
		
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
					if (is_string($val) && strlen($val) == 0) continue;
					$this->data[$this->controller->modelClass][$param] = $val;
				}
			}
			
			# CLEARS DATA IF ARRAY IS EMPTY
			if (empty($this->data[$this->controller->modelClass])) unset($this->data[$this->controller->modelClass]);
			
		}
		
	}

	public function beforeRender(Controller $controller) {

		

	}

	public function setResponse($code, $custom_message = null, $errors = array()) {

		$this->controller->viewClass = 'Json';

		// $this->controller->layout = 'Api.default';
		// $this->controller->autoRender = false;
		// $this->controller->viewClass = 'Api.Api';

		// $header = $this->controller->httpCodes($code);
		// $this->controller->header('HTTP/1.0 ' . $code . ' ' . $header[$code]);
		// $this->controller->set('http_code', $code);
		
		// if (is_null($custom_message)) {
		// 	$custom_message = $header[$code];
		// }

		unset($this->controller->viewVars['title_for_layout']);
		
		$this->controller->set('code', $code);
		$this->controller->set('msg', $custom_message);
		$this->controller->set('errors', $errors);
		
		header('Access-Control-Allow-Origin: *');

		$this->controller->set('_serialize', array_keys($this->controller->viewVars));
		
		// $this->controller->render('/Api/Elements/json'); //$this->controller->action, 'Api.default', '/stub');
		
	}

}
?>