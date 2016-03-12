<?php 

class UserController
{
	private $app;
	private $errors;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function login($post, $validation)
	{
		$validForm = self::isValidForm($post, $validation);
		// If error show in form
		if($validForm){
	    	self::setFlashMessages($post);
			return array("status" => "error", "errors" => $this->errors);
		}
		// fake db insert
		$saveDB = true;
		if($saveDB){
			return array("status" => "ok");
		}

		return array("status" => "errorDB");
	}


	private function isValidForm($post, $validation)
	{
		$error = false;
		$errors = null;
		$resp = array("status" => "ok");
		$validator = $validation->make($post, array(
			'email' => 'required|email',
			'password' => 'required',
			'phone' => 'required|numeric'
		));

	    if ($validator->fails()) {
	        $this->errors = $validator->errors();
	    	$error = true;
	    }
	    return $error;
	}


	private function setFlashMessages($post)
	{
		foreach ($post as $key => $value) {
			$this->app->flashNow($key , $value);
		}
	}
}

?>
















