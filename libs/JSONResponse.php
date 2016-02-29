<?php

class JSONResponse {
	private $status;
	private $response;
	
	public static function newWithErrorMessage($message, $error_code = 0, $extras = array(), $status = 200) {
		$jsonResp = new JSONResponse();
		$jsonResp->status = 'error';
		$jsonResp->response = array('error_code'=>$error_code, 'error_message'=>$message);
		if(count($extras) > 0)
			$jsonResp->response = array_merge($jsonResp->response, $extras);
			
		return $jsonResp;
	}
	
	public static function newWithSuccessMessage($data) {
		$jsonResp = new JSONResponse();
		$jsonResp->status = 'ok';
		$jsonResp->response = $data;
		return $jsonResp;
	}
	
	public function printResponse() {
		header("Content-Type: application/json; charset=UTF-8");
		echo ($this->getResponse());
	}	
	
	public function getResponse() {
		//return json_encode(array('result' => $this->status, 'response'=> $this->response));
		return $this->json_unescaped_encode(array('result' => $this->status, 'response'=> $this->response));
	}
	
	public function isErrorResponse(){
		return $this->status == 'error';
	}
	
	public function addExtrasToErrorResponse($extras){
		$this->response = array_merge($this->response, $extras);
	}
	
	
	/*
	 * Funcion para reemplazar el json_encode($arr, JSON_UNESCAPED_UNICODE) al utilizar PHP 5.3 o anterior
	 */
	function json_unescaped_encode($arr) {
		$str = json_encode($arr);
		$str = preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
				function ($matches) {
					$sym = mb_convert_encoding(pack('H*', $matches[1]),'UTF-8','UTF-16');
					return $sym;
				},$str);
		return $str;		
	}
	
}