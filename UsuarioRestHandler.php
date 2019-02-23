<?php
require_once("SimpleRest.php");
require_once("Usuario.php");
		
class UsuarioRestHandler extends SimpleRest {

	function getAllUsers() {	

		$usuario = new Usuario();
		$rawData = $usuario->getAllUsers();

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No users found!');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["usuarios"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	
	function getUser($correo, $password) {	
		
		$usuario = new Usuario();
		$rawData = $usuario->getUser($correo, $password);
		//echo $rawData;
		if(empty($rawData)) {
			$statusCode = 200;
			$vacio = 0;
		} else {
			$vacio = 1;
			$statusCode = 200;
			$result["usuarios"] = $rawData;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
				
		if(strpos($requestContentType,'application/json') !== false){
			if ($vacio == 0) 
			{
				
				$rawData=array(['code' =>'00','error'=>'Usuario no encontrado']);
				$result["usuarios"] = $rawData;
				$response = json_encode($result);
			}
			else{
				$response = $this->encodeJson($result);
			}
			echo $response;
		}
	}
	function userLogin($correo, $password) {	
		$usuario = new Usuario();
		$rawData = $usuario->userLogin($correo, $password);
		//echo $rawData;
		if(empty($rawData)) {
			$statusCode = 404;
			
			$rawData = array('error' => "Usuario o contraseña incorrectos");		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["usuarios"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	
	
	
	function userExists($dni) {	
		/*$usuario = new Usuario();
		$rawData = $usuario->userExists($dni);
		if(empty($rawData)) {
			$statusCode = 404;
			
			$rawData = array('error' => "Ha sucedido un error");		
		} else {
			$statusCode = 200;
		}*/

	
		
		$usuario = new Usuario();
		$rawData = $usuario->userExists($dni);
		//echo $rawData;
		if(empty($rawData)) {
			$statusCode = 404;
			
			$rawData = array('error' => "User $dni not found!");		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["usuarios"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	function addUser($dni, $nombre, $apellidos, $correo, $contrasenya, $tipo, $telefono, $codProf) {	
		//echo $dni $nombre $correo $contrasenya $tipo $telefono $codProf;
		$usuario = new Usuario();
		$usuario->addUser($dni, $nombre, $apellidos, $correo, $contrasenya, $tipo, $telefono, $codProf);
		
		
		//despues de insertar comprobamos y devolvemos si existe
		$rawData = $usuario->userExists($dni);
		//echo $rawData;
		if(empty($rawData)) {
			$statusCode = 404;
			
			$rawData = array('error' => "User $dni not found!");		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["usuarios"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
		
	
	}
	
	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
}
?>