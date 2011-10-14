Configuration
=============

	class AppController extends Controller {

		public $components = array(
			'Api.Api',
			'RequestHandler',
			'Auth',
			'Session'
		);

Usage
=====

	$this->Api->setResponse(200, 'Operation successful');