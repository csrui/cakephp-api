Api Component for CakePHP 2.0
=============================




Configuration
-------------

	class AppController extends Controller {

		public $components = array(
			'Api.Api',
			'RequestHandler',
		);

Usage
-----

	$this->Api->setResponse(200, 'Operation successful');