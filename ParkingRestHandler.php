<?php
require_once("SimpleRest.php");
require_once("Parking.php");
		
class ParkingRestHandler extends SimpleRest {

	function getPlazas($requestCode) {	

		$parking = new Parking();
		$rawData = $parking->getPlazas($requestCode);

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No se encontraron plazas!');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["plazas"] = $rawData;
				
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