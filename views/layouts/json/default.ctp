<?php

	// header("Pragma: no-cache");
	// header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header("X-JSON: ". $content_for_layout);
	header('Content-Type: application/json');

	$data = $this->viewVars;
	$errors = array();
	
	if (isset($data['errors']) || is_null($data['errors'])) {
		$errors = $data['errors'];
		unset($data['errors']);
	}
	
	unset($data['title_for_layout']);
	unset($data['http_code']);

	$full_response = array(
		'result' => array(
			'title' => $title_for_layout,
			'code' => $http_code,
			'msg' => $this->Session->read('Message.flash.message')
		),
		'response' => $data,
		'errors' => $errors
	);

	$js_response = $this->Js->object($full_response); 
	
	if (isset($_GET['callback'])) {
		
		echo sprintf('%s (%s)', $_GET['callback'], $js_response);
		
	} else {
		
		echo $js_response;

	}
	
?>