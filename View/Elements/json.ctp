<?php

	$js_response = $this->Js->object($response);
	
	if (isset($_GET['callback'])) {
		
		echo sprintf('%s (%s)', $_GET['callback'], $js_response);
		
	} else {
		
		echo $js_response;

	}
	
?>