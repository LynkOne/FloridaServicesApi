<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Parking {
	private $plazas = array();
	/*
		you should hookup the DAO here
	*/
	public function getPlazas($requestCode){
		switch($requestCode){

				case "ocupadas":
					$query = "SELECT ID, plaza, case ocupado when 0 then 'false' else 'true' end as ocupado FROM parking WHERE ocupado = 1";
					break;
				case "libres":
					$query = "SELECT ID, plaza, case ocupado when 0 then 'false' else 'true' end as ocupado FROM parking WHERE ocupado = 0";
					break;
				default:
					$query = "SELECT ID, plaza, case ocupado when 0 then 'false' else 'true' end as ocupado FROM parking";
					break;
		}		
		$dbcontroller = new DBController();
		$this->plazas = $dbcontroller->executeSelectQuery($query);
		return $this->plazas;
	}	
	
	
}
?>