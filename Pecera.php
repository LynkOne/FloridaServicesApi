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
		date_default_timezone_set('Europe/Madrid');
		$date = date('Y-m-d H:i:s'); // use actual date() format displayed in your table.
		switch($requestCode){
				
				case "ocupadas":
					$query="SELECT *, TIME(hora_de_reserva+tiempo_reservado) AS fin_de_reserva FROM peceras WHERE DATE('$date')<=DATE(hora_de_reserva) AND  TIME('$date')<TIME(hora_de_reserva+tiempo_reservado)";
					break;
				case "libres":
					$query="SELECT * FROM peceras WHERE DATE('$date')>DATE(hora_de_reserva) AND  TIME('$date')<TIME(hora_de_reserva+tiempo_reservado)";
					break;
				default:
					$query = "SELECT * FROM peceras";
					break;
		}		
		$dbcontroller = new DBController();
		$this->peceras = $dbcontroller->executeSelectQuery($query);
		return $this->peceras;
		//return $date;
	}
	public function abandonarPecera($id, $dni){
					
		
		$query = "UPDATE peceras SET tiempo_reservado='00:00:00', dni_usuario_reserva=null WHERE id=$id AND dni_usuario_reserva='$dni'";
					
		$dbcontroller = new DBController();
		$dbcontroller->executeSelectQuery($query);
		//return $this->peceras;
	}
	public function reservarPecera($id, $tiempo, $dni){
		date_default_timezone_set('Europe/Madrid');
		$date = date('Y-m-d H:i:s'); // use actual date() format displayed in your table.			
		//UPDATE peceras SET tiempo_reservado='05:00:00', hora_de_reserva='2019-02-25 00:59:43', dni_usuario_reserva='073579654D' WHERE id='1'
		$query = "UPDATE peceras SET tiempo_reservado='$tiempo', hora_de_reserva='$date', dni_usuario_reserva='$dni' WHERE id='$id'";
					
		$dbcontroller = new DBController();
		$dbcontroller->executeSelectQuery($query);
		//return $this->peceras;
	}	
	
	
}
?>