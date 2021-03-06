<?php
require_once("SimpleRest.php");
require_once("Pecera.php");
		
class PeceraRestHandler extends SimpleRest {

	function getPeceras($requestCode) {	

		$pecera = new Pecera();
		$rawData = $pecera->getPeceras($requestCode);

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No se encontraron peceras!');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["peceras"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			
			echo $response;
		}
	}
	public function abandonarPecera($id, $dni){
		$pecera = new Pecera();
		
		//Ejecutamos update
		$rawData = $pecera->abandonarPecera($id, $dni);
		//$aux="todas";
		//$rawData = $pecera->getPeceras($aux);
		
		if(empty($rawData)) {
			$statusCode = 200;
			//$rawData = array('error' => 'No se encontraron peceras!');		
		} else {
			$statusCode = 200;
			//$rawData = array('correcto' => 'Actualizado!');	
		}
		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["peceras"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	public function reservarPecera($id, $tiempo, $dni){
		$pecera = new Pecera();
		
		//Ejecutamos update
		$rawData = $pecera->reservarPecera($id, $tiempo, $dni);		
		if(empty($rawData)) {
			$statusCode = 200;		
		} else {
			$statusCode = 200;
		}
		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["peceras"] = $rawData;
				
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