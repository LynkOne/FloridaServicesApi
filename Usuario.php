<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Usuario {
	private $usuarios = array();
	/*
		you should hookup the DAO here
	*/
	public function getAllUsers(){
		$query = "SELECT dni, nombre, correo, tipo, telefono, cod_prof FROM usuarios";
		$dbcontroller = new DBController();
		$this->usuarios = $dbcontroller->executeSelectQuery($query);
		return $this->usuarios;
	}	
	
	public function getUser($correo, $password){
		$query = "SELECT dni, nombre, apellidos, correo, case tipo when 0 then 'false' else 'true' end as tipo, telefono, cod_prof FROM usuarios WHERE correo='$correo' AND contrasenya='$password'";
		$dbcontroller = new DBController();
		$this->usuarios = $dbcontroller->executeSelectQuery($query);
		return $this->usuarios;
	}
	public function userLogin($correo, $password){
		$query = "SELECT COUNT(*) AS 'login' FROM usuarios WHERE correo='$correo' AND contrasenya='$password'";
		$dbcontroller = new DBController();
		$resultado = $dbcontroller->executeSelectQuery($query);
		
		return $resultado;
	}		
	
	public function userExists($dni){
		$dniaux=str_pad($dni, 10, "0", STR_PAD_LEFT);
		$query = "SELECT COUNT(*) AS 'existe' FROM usuarios WHERE dni='$dniaux'";
		$dbcontroller = new DBController();
		$resultado = $dbcontroller->executeSelectQuery($query);
		
		return $resultado;
	}
	
	public function addUser($dni, $nombre, $apellidos, $correo, $contrasenya, $tipo, $telefono, $codProf){
		$dniaux=str_pad($dni, 10, "0", STR_PAD_LEFT);
		if($codProf===NULL){
			$query = "INSERT INTO usuarios (dni, nombre, apellidos, correo, contrasenya, tipo, telefono, cod_prof) VALUES ('$dniaux','$nombre','$apellidos','$correo','$contrasenya',$tipo,$telefono,NULL)";
		}
		else{
			$query = "INSERT INTO usuarios (dni, nombre, apellidos, correo, contrasenya, tipo, telefono, cod_prof) VALUES ('$dniaux','$nombre','$apellidos','$correo','$contrasenya',$tipo,$telefono,$codProf)";
		}
			
		
		$dbcontroller = new DBController();
		$dbcontroller->executeSelectQuery($query);
		//return $resultado;
	}
}
?>