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
				//Se añade el NOW()+010000 para compensar la hora del servidor mysql del hosting
				case "ocupadas":
					
					//$query = "SELECT *, TIME(hora_de_reserva+tiempo_reservado) AS fin_de_reserva FROM peceras WHERE TIME($date)<TIME(hora_de_reserva+tiempo_reservado)AND DATE($date)>=DATE(hora_de_reserva);";
					$query="SELECT *, TIME(hora_de_reserva+tiempo_reservado) AS fin_de_reserva FROM peceras WHERE DATE('$date')<=DATE(hora_de_reserva) AND  TIME('$date')<TIME(hora_de_reserva+tiempo_reservado)";
					break;
				case "libres":
					//$query = "SELECT * FROM peceras WHERE TIME(NOW()+010000)>TIME(hora_de_reserva+tiempo_reservado)AND DATE(NOW()+010000)>=DATE(hora_de_reserva);";
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
	
	
}
?>