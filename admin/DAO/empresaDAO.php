<?php
	require_once(__DIR__ . "/../classes/empresa.php");
	require_once(__DIR__ . "/../../includes/conexion.inc");
	
	// recuperamos los banners del usuario dado
	function getEmpresa($usuario){
		global $connexion;
		// variabales
		$arrBanners = array();
	
		try{
			// recuperamos los banner del usuario
			$query = "SELECT id, empresa, calle, numero, codigo_postal,telefono, email,  web, fecha_alta, aud_fecha, aud_usuario, activo
						  FROM n4_adsrv_empresas where id = ".$usuario;
			$rsempresa = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsempresa)) {
			
				// creamos una instancia de banner
				$oEmpresa = new empresa($fila);
			}
			
			return $oEmpresa;
			
		}catch (Exception $ex){
			echo "Error: empresaDAO.getEmpresa";
			return null;
		}
		
	}
	
	// actualizamos los datos de la empresa 
	function actualizarDatosEmpresa ($nombre, $calle, $numero, $cp, $telefono, $email, $web, $usuario) {
		global $connexion;
		try{
			
			// recuperamos los banner del usuario
			$query = "UPDATE n4_adsrv_empresas SET empresa = '".reemplazarCaracteres($nombre)."', calle= '".reemplazarCaracteres($calle)."', numero = ".$numero.", codigo_postal = ".$cp.", 
					telefono = '".$telefono."', email = '".$email."', web = '".$web."' WHERE id = ".$usuario;
		
			$rsempresa = mysqli_query($connexion, $query);
				
		}catch (Exception $ex){
			echo "Error: empresaDAO.actualizarDatosEmpresa";
			return null;
		}
	}
	
?>

