<?php 

class Utils
{
	const SALT = "saltstring";

	/**
	 * Genera un password hash
	 * @param string $password
	 * @return string
	 */
	public static function hashPassword($password) {
        return hash('sha512', self::SALT . $password);
    }

   	/**
	 * Chequea si el password pasado es valido
	 * @param string $password
	 * @param string $hash
	 * @return boolen
	 */
    public static function verifyPassword($password, $hash) {
        return ($hash == self::hashPassword($password));
    }


	public static function saveImageFromUrl($pathToSave, $url)
	{
		try{
			$content = file_get_contents($url);
			if(file_put_contents($pathToSave, $content)){
				return true;
			}
		}catch (Exception $e) {
			return false;
		}
	}


	/**
	 * Valida si el usuario es admin , mediante la sesion
	 * @return mixed
	 */
	public static function isAdmin()
	{
		$app = \Slim\Slim::getInstance();
    	if(!isset($_SESSION["admin"])){
			$app->redirect("/admin/login");
		}
	}


	/**
	 * Chequea si el archivo subido es una imagen valida
	 * @param array  $files
	 * @return boolean
	 */
	public static function isValidImage($filesImage)
	{
		$imageTmpName = $filesImage['tmp_name'];
		if(count($imageTmpName) == 0 ||  $imageTmpName == ""){
			return false;
		}

		$allowedExt = array("jpg", "jpeg", "png", "gif");
		
		try{
			$ext = image_type_to_extension(exif_imagetype($imageTmpName),false);
			if(!in_array($ext, $allowedExt)){
				return false;
			}
			return true;
		}catch (Exception $e) {
			return false;
		}
	}


	/**
	 * Guarda la imagen en disco
	 * @param array  $files
	 * @return string
	 */
	public static  function saveImage($files, $pathToSave)
	{
		
		$imageTmpName = $files['tmp_name']; 
		// Save image in disk
		$filename = md5(uniqid(rand(), true)) . ".jpg";
		$fullPath =  $pathToSave . $filename;
		if(move_uploaded_file($imageTmpName, "../" . $fullPath)){
			return $fullPath;
		}
	}


	/**
	 * Guarda logs de request json productos
	 * @param array  $request
	 * @return boolean
	 */

	public static function saveJsonRequestBody($path, $reqBody)
	{
		try{
			$fp = fopen($path, 'a+');
			fwrite($fp, "\n");
			$save = fwrite($fp, $reqBody);
			fclose($fp);
			return true;
		}catch (Exception $e){}
	}


	/**
	 * Valida que un parametro sea de valor numerico
	 * @param string $id
	 * @return boolean
	 */
	public static function isNotNumber($id)
	{
		if(!is_numeric($id) && $id < 1){
			return true;
	
		}
	}


	/**
	 * Elimina espacios y sanitiza un string
	 * @param string $string
	 * @return string
	 */
	public static function trimAndSanitizeValue($string)
	{
		return trim(filter_var($string, FILTER_SANITIZE_STRING));

	}


	/**
	 * Limpia cadena de texto para mostra en url
	 * @param string $string
	 * @return string
	 */

	public static function cleanUrl($string)
	{
		$string = str_replace(array('á','é','í','ó','ú','ñ'), array('a','e','i','o','u','n'), trim($string));
		return strtolower(str_replace(" ", "-", $string));
	}	

	/**
	 * @param string $value
	 * @return string
	 */
	public static function twitterEncode($value){
		return utf8_decode(urlencode($value));
	}
}

?>




























