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

				case "ocupadas":
					$query = "SELECT * , TIME(hora_de_reserva+tiempo_reservado) AS fin_reserva FROM peceras WHERE TIME(NOW())<TIME(hora_de_reserva+tiempo_reservado)AND DATE(NOW())>=DATE(hora_de_reserva);";
					break;
				case "libres":
					$query = "SELECT * , TIME(hora_de_reserva+tiempo_reservado) AS fin_reserva FROM peceras WHERE TIME(NOW())>TIME(hora_de_reserva+tiempo_reservado)AND DATE(NOW())>=DATE(hora_de_reserva);";
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