<?php
require_once(__DIR__ . "/../classes/usuario.php");
require_once(__DIR__ . "/../../includes/conexion.inc");

// recuperamos datos del usuario
function getUsuario( $usuario){
	global $connexion;
	try{
		// recuperamos los banner del usuario
		$query = "SELECT id, empresaID, username, password, nombre, apellidos, telefono, email, fecha_alta, fecha_ult_acceso, activada FROM n4_adsrv_usuarios WHERE id = ".$usuario;
		$rsusuario = mysqli_query($connexion, $query);
		while($fila = mysqli_fetch_array($rsusuario)) {
			// creamos una instancia de usuario
			$oUsuario = new usuario($fila);
		}
			return $oUsuario;
	}catch (Exception $ex){
		echo "Error: usuarioDAO.getUsuario";
		return null;
	}
}

// cambiamos la password
function cambiarClave( $nuevaPass, $usuario){
	global $connexion;
	try{
		// recuperamos los banner del usuario
		$query = "UPDATE n4_adsrv_usuarios SET password = '".$nuevaPass."' WHERE id = ".$usuario;
		$rsusuario = mysqli_query($connexion, $query);
		
			
	}catch (Exception $ex){
		echo "Error: usuarioDAO.cambiarClave";
		return null;
	}
}

// validamos acceso a la aplicacion
function validarAcceso($username, $password){
	global $connexion;
	try{
		// recuperamos los banner del usuario
		$query = "SELECT id, empresaID, username, password, nombre, apellidos, telefono, email, fecha_alta, fecha_ult_acceso, activada
		 			FROM n4_adsrv_usuarios WHERE username = '".$username."' and password = '".$password."' AND activada = 1";
		$rsusuario = mysqli_query($connexion, $query);
		while($fila = mysqli_fetch_array($rsusuario)) {
			// creamos una instancia de usuario
			$oUsuario = new usuario($fila);
		}
		if (isset($oUsuario) && $oUsuario!= null){
			return $oUsuario; 
		}else{
			return null;
		}
	}catch (Exception $ex){
		echo "Error: usuarioDAO.validarAcceso";
		return null;
	}
}

// guardamos el ultimo acceso a la aplicacion
function grabarUltimoAcceso($usuario){
	global $connexion;
	try{
		// recuperamos los banner del usuario
		$query = "UPDATE n4_adsrv_usuarios SET fecha_ult_acceso = '".$hoy = date("Y-m-d H:i:s")."' WHERE id = ".$usuario;
		$rsusuario = mysqli_query($connexion, $query);
	
			
	}catch (Exception $ex){
		echo "Error: usuarioDAO.grabarUltimoAcceso";
		return null;
	}
}
?>