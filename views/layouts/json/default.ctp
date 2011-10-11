<?php

	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header("X-JSON: ". $content_for_layout);


	$data = $this->viewVars;
	$errors = array();
	
	if (isset($data['errors'])) {
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

	echo $this->Js->object($full_response); 
	
?>