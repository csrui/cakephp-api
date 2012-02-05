<?php

/**
 * API View
 *
 * @package Api
 */
class ApiView extends View {

	/**
	 * Renders view for given action and layout.
	 *
	 * @param string $action Name of action to render for
	 * @param string $layout Layout to use
	 * @return string Rendered Element
	 */
	public function render($action = null, $layout = null) {

		$this->plugin = 'Api';
		$this->autoLayout = false;
					
		$response = array(
			'result' => array(
				'title' => $this->getVar('title_for_layout'),
				'code' => $this->getVar('http_code'),
				'msg' => $this->getVar('msg')
			),
			'errors' => $this->getVar('errors')
		);
	
		unset($this->viewVars['errors']);
		unset($this->viewVars['title_for_layout']);
		unset($this->viewVars['http_code']);		
		unset($this->viewVars['msg']);
		
		$response['response'] = $this->viewVars;
	
		// Remove DebugKit stuff
		unset($response['response']['debugToolbarPanels']);
		unset($response['response']['debugToolbarJavascript']);
	
		$this->set('response', $response);
	
		if ($this->request->ext == 'json') {
			$this->loadHelper('Js');
		}
	
		$out = parent::render('/Elements/'.$this->request->ext, $layout);
	
		if (empty($this->output)) {
			return $out;
		}
		return $this->output;
	}
}
