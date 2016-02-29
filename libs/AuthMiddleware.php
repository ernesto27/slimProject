<?php  

class AuthMiddleware extends \Slim\Middleware
{	
	const AUTH_TOKEN = 'sometoken'; // development test

	public function call()
	{
		$req = $this->app->request;
		$headers = $req->headers;

		$mainURI = $req->getResourceUri() == '/';

		if (!$headers->get('Auth-Token')) {
				$this->app->response->setStatus(403);
				$errorJson = JSONResponse::newWithErrorMessage('Access Token Required', 403);
				$errorJson->printResponse();
				return;
		}


		$token = $headers->get('Auth-Token');
		if ($token != self::AUTH_TOKEN) {
			$this->app->response->setStatus(403);
			$errorJson = JSONResponse::newWithErrorMessage('Invalid Access Token', 403);
			$errorJson->printResponse();
			return;
		}


		$this->next->call();
	}

}

?>
