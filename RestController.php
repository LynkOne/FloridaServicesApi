<?php
require_once("UsuarioRestHandler.php");
require_once("ParkingRestHandler.php");
require_once("PeceraRestHandler.php");
$request_method=$_SERVER["REQUEST_METHOD"];	
switch($request_method)
	{
		case 'GET':
			// Retrive Products
			//original code
			$view = "";
			if(isset($_GET["view"]))
				$view = $_GET["view"];
			/*
			controls the RESTful services
			URL mapping
			*/
			switch($view){

				case "all":
					// to handle REST Url /users/list/
					$usuarioRestHandler = new UsuarioRestHandler();
					$usuarioRestHandler->getAllUsers();
					break;
				case "" :
					//404 - not found;
					break;
				case "dni": //comprobar que el usuario existe segun el DNI /users/dni/73579654D/
					$dni = "";
					if(isset($_GET["dni"]))
						$dni = $_GET["dni"];
					$usuarioRestHandler = new UsuarioRestHandler();
					$usuarioRestHandler->userExists($dni);
					break;
				case "login"://devuelve un 0 o un 1 si el usuarioy password son correctos (no se usa actualmente)
					$correo="";
					$password="";
					if(isset($_GET["correo"]))
						$correo=$_GET["correo"];
					if(isset($_GET["password"]))
						$password=$_GET["password"];
					$usuarioRestHandler = new UsuarioRestHandler();
					$usuarioRestHandler->userLogin($correo, $password);
					
					break;
				case "parking"://devuelve todas las plazas por defecto (si requestCode es libres u ocupadas devuelve las plazas libres/ocupadas)
					if(isset($_GET["requestCode"])){
						$requestCode=$_GET["requestCode"];
					}
					else{
						$requestCode="todas";
					}
						
					$parkingRestHandler = new ParkingRestHandler();
					$parkingRestHandler->getPlazas($requestCode);
					break;
					
				case "peceras":
					if(isset($_GET["requestCode"])){
						$requestCode=$_GET["requestCode"];
					}
					else{
						$requestCode="todas";
						}
					$peceraRestHandler = new PeceraRestHandler();
					$peceraRestHandler->getPeceras($requestCode);
					break;
				default: //Devolver todos los datos del usuario segun el email
					$password="";
					if(isset($_GET["password"]))
						$password=$_GET["password"];
					$usuarioRestHandler = new UsuarioRestHandler();
					$usuarioRestHandler->getUser($view, $password);
					break;
	
			}
			break;
		case 'POST':
			// Update Product
			parse_str(file_get_contents("php://input"),$_PUT);
			$accion = "";
			if(isset($_GET["accion"])){
				$accion = $_GET["accion"];
			}
			switch($accion){

				case "abandonarpecera":
					if(isset($_GET["id"])){
						$id=$_GET["id"];
					}
					if(isset($_GET["dni"])){
						$dni=$_GET["dni"];
					}
					
					$peceraRestHandler = new PeceraRestHandler();
					$peceraRestHandler->abandonarPecera($id, $dni);
					
					break;
				case "reservarpecera":
					if(isset($_GET["id"])){
						$id=$_GET["id"];
					}
					if(isset($_GET["dni"])){
						$dni=$_GET["dni"];
					}
					if(isset($_GET["tiempo"])){
						$tiempo=$_GET["tiempo"];
					}
					$peceraRestHandler = new PeceraRestHandler();
					$peceraRestHandler->reservarPecera($id, $tiempo, $dni);
					break;
				default:
					// Insert User
					$dni=$_GET["dni"];
					$nombre=$_GET["nombre"];
					$apellidos=$_GET["apellidos"];
					$correo=$_GET["correo"];
					$contrasenya=$_GET["contrasenya"];
					$tipo=$_GET["tipo"];
					$telefono=$_GET["telefono"];
					$codProf=$_GET["codProf"];
			
					$usuarioRestHandler = new UsuarioRestHandler();
					$usuarioRestHandler->addUser($dni, $nombre, $apellidos, $correo, $contrasenya, $tipo, $telefono, $codProf);
					//default action
					break;
			
			break;
		case 'PUT':
			//PUT NO SOPORTADO POR 000WEBHOST
			}
			break;
		case 'DELETE':
			// Delete NO SOPORTADO POR 000WEBHOST
			
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}





?>
