<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Pecera {
	private $peceras = array();
	/*
		you should hookup the DAO here
	*/
	public function getPeceras($requestCode){
		
		switch($requestCode){
				//Se añade el NOW()+010000 para compensar la hora del servidor mysql del hosting
				case "ocupadas":
					$query = "SELECT * FROM peceras WHERE TIME(NOW()+010000)<TIME(hora_de_reserva+tiempo_reservado)AND DATE(NOW()+010000)>=DATE(hora_de_reserva);";
					break;
				case "libres":
					$query = "SELECT * FROM peceras WHERE TIME(NOW()+010000)>TIME(hora_de_reserva+tiempo_reservado)AND DATE(NOW()+010000)>=DATE(hora_de_reserva);";
					break;
				default:
					$query = "SELECT * FROM peceras";
					break;
		}		
		$dbcontroller = new DBController();
		$this->peceras = $dbcontroller->executeSelectQuery($query);
		return $this->peceras;
	}	
	
	
}
?>