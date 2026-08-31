<?php
	require_once(__DIR__ . "/../classes/banner.php");
	require_once(__DIR__ . "/../../includes/conexion.inc");
	
	// recuperamos los banners del usuario dado
	function getBanners($usuario){
		global $connexion;
		// variables
		$arrBanners = array();
		try{
			// recuperamos los banner del usuario
			$query = "SELECT id, empresaID, imagen, url, nombre, descripcion, activo, estado, fecha_alta
						  FROM n4_adsrv_banners where (empresaID = ".$usuario." or -999 = ".$usuario.") and eliminado = 0";
			
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
			
				// creamos una instancia de banner
				$oBanner = new banner($fila);
				array_push($arrBanners,$oBanner);
			}
			return $arrBanners;
			
		}catch (Exception $ex){
			echo "Error: bannerDAO.getBanners";
			return null;
		}
		
	}
	
	// recuperamos los banners del usuario dado
	function getBanner($bannerID){
		global $connexion;
		// variables
		$arrBanners = array();
		$oBanner = null;
		try{
			// recuperamos los banner del usuario
			$query = "SELECT id, empresaID, imagen, url, nombre, descripcion, activo, estado, fecha_alta
							  FROM n4_adsrv_banners where id = ".$bannerID." and eliminado = 0";
				
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
					
				// creamos una instancia de banner
				$oBanner = new banner($fila);
			}
			return $oBanner;
				
		}catch (Exception $ex){
			echo "Error: bannerDAO.getBanner";
			return null;
		}
	
	}
	
	// recuperamos los clicks
	function getClicksBanner($oBanner){
		global $connexion;
		// variables
		$arrBanners = array();
		$clicks = 0;
		try{
			// recuperamos los banner del usuario
			$query = "SELECT clicks FROM n4_adsrv_estadisticas_resumen where empresaID = ".$oBanner->getIdEmpresa()." AND bannerID = ".$oBanner->getId() ;
			
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
			
				// creamos una instancia de banner
				$clicks = $fila[0];
			}
			
			return $clicks;
		}catch (Exception $ex){
			echo "Error: bannerDAO.getClicksBanner";
			return null;
		}
	}
	
	
	// recuperamos los impresiones
	function getImpresionesBanner($oBanner){
	global $connexion;
	// variables
	
		try{ 
			$arrBanners = array();
			$impresiones = 0;
			// recuperamos los banner del usuario
			$query = "SELECT impresiones FROM n4_adsrv_estadisticas_resumen where empresaID = ".$oBanner->getIdEmpresa()." AND bannerID = ".$oBanner->getId() ;
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
			
			// creamos una instancia de banner
				$impresiones = $fila[0];
			}
			
			return $impresiones;
		}catch (Exception $ex){
			echo "Error: bannerDAO.getImpresionesBanner";
			return null;
		}
	}
	
	// cambiamos el estado ACTIVO el banner
	function actualizarBannerActivo($banner,$usuario,$estado, $activo){
		global $connexion;
		try{
			$hoy = date("Y-m-d H:i:s");
			
			// recuperamos los banner del usuario
			$query = "UPDATE n4_adsrv_banners SET activo = ".$activo.", estado = ".$estado.", aud_fecha = '".$hoy."', aud_usuario = ".$usuario.", aud_accion='Cambio ACTIVO: ".$activo."'  WHERE id = ".$banner ;
			$rsbanner = mysqli_query($connexion, $query);
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.actualizarBannerActivo";
			return null;
		}
	}
	
	
	// cambiamos la marca de ESTADO delbanner
	function actualizarBannerEstado($banner,$usuario, $estado, $activo){
		global $connexion;
		try{
		$hoy = date("Y-m-d H:i:s");
			
		// recuperamos los banner del usuario
		$query = "UPDATE n4_adsrv_banners SET activo = ".$activo.", estado = ".$estado.", aud_fecha = '".$hoy."', aud_usuario = ".$usuario.", aud_accion='Cambio ESTADO: ".$estado."'  WHERE id = ".$banner;
		
		$rsbanner = mysqli_query($connexion, $query);
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.actualizarBannerEstado";
			return null;
		}
	}
	
	
	// Marcamos como eliminado el banner recibido. NO se borra, simplemente se desactiva la visualizaci�n
	function eliminarBanner($banner,$usuario){
		global $connexion;
		try{
		$hoy = date("Y-m-d H:i:s");
		
		// recuperamos los banner del usuario
		$query = "UPDATE n4_adsrv_banners SET eliminado = 1, activo = 0, estado = 0, aud_fecha = '".$hoy."', fecha_baja = '".$hoy."', aud_usuario = ".$usuario.", aud_accion='Eliminar banner'  WHERE id = ".$banner;
		
		$rsbanner = mysqli_query($connexion, $query);
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.eliminarBanner";
			return null;
		}
	}
	
	// recuperamos la ultima id de un banner de la empresa dada
	function getUltimoIdBannerEmp($usuario){
		global $connexion;
		try{
				
			// recuperamos los banner del usuario
			$query = "SELECT max(id)+1 from n4_adsrv_banners WHERE empresaID = ".$usuario;
		
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
				return $fila[0];
			}
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.getUltimoIdBannerEmp";
			return null;
		}
	}
	
	// grabamos el nuevo banner en BD
	function grabarNuevoBanner($nombre, $imagen, $url, $estado, $descripcion, $usuario){
		global $connexion;
		try{
			
			$hoy = date("Y-m-d H:i:s");
			// recuperamos los banner del usuario
			$query = "INSERT INTO n4_adsrv_banners (empresaID, imagen, url, nombre, descripcion, activo, estado, eliminado, fecha_alta, aud_fecha, aud_usuario, aud_accion) 
			VALUES (".$usuario.", '".$imagen."', '".$url."','".reemplazarCaracteres($nombre)."', '".reemplazarCaracteres($descripcion)."', 1, ".$estado.", 0, '".$hoy."', '".$hoy."', ".$usuario.", 'Alta nueba de banner')";
		
			$rsbanner = mysqli_query($connexion, $query);
			
			// recuperamos los banner del usuario
			$query = "SELECT max(id) from n4_adsrv_banners WHERE empresaID = ".$usuario." AND imagen = '".$imagen."'";
		
			$rsbanners = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsbanners)) {
				$nuevoID = $fila[0];
			}
			$query = "INSERT INTO n4_adsrv_estadisticas_resumen (empresaID, bannerID, clicks, impresiones)
						VALUES (".$usuario.", ".$nuevoID.", 0, 0)";
			
			$rsbanner = mysqli_query($connexion, $query);
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.grabarNuevoBanner";
			return null;
		}
	}
	
	// actualizamos los datos del banner en BD
	function grabarActualizacionBanner ($nombre, $imagen, $url, $estado, $descripcion, $usuario, $bannerID){
		global $connexion;
		try{
			
			$hoy = date("Y-m-d H:i:s");
			// recuperamos los banner del usuario
			$query = "UPDATE n4_adsrv_banners SET imagen = '".$imagen."', url = '".$url."', nombre = '".reemplazarCaracteres($nombre)."', 
					descripcion = '".reemplazarCaracteres($descripcion)."', estado = ".$estado.", aud_fecha = '".$hoy."', 
					aud_usuario = ".$usuario.", aud_accion = 'Modificacion de Banner' WHERE id = ".$bannerID;
			
			$rsbanner = mysqli_query($connexion, $query);
		
		}catch (Exception $ex){
			echo "Error: bannerDAO.grabarActualizacionBanner";
			return null;
		}
	}
	
	function reemplazarCaracteres($str){
		/*$str = str_replace("�","&aacute;",$str);
		$str = str_replace("�","&eaacute;",$str);
		$str = str_replace("�","&iacute;",$str);
		$str = str_replace("�","&oacute;",$str);
		$str = str_replace("�","&uacute;",$str);
		$str = str_replace("�","&Aacute;",$str);
		$str = str_replace("�","&Eacute;",$str);
		$str = str_replace("�","&Iacute;",$str);
		$str = str_replace("�","&Oacute;",$str);
		$str = str_replace("�","&Uacute;",$str);
		$str = str_replace("�","&ntilde;",$str);
		$str = str_replace("�","&Ntilde;",$str);
		$str = str_replace("�","&iquest;",$str);
		$str = str_replace("�","&iexcl;",$str);*/
		return $str;
	}
	
	// grabamos el nuevo banner en BD
	function actualizarRegistros(){
		global $connexion;
		try{
				
			// recuperamos los banner del usuario
			$query = "SELECT n4_adsrv_estadisticas_n4_adsrv_banners_id, n4_adsrv_estadisticas_n4_adsrv_banners_n4_adsrv_empresas_id,
			n4_adsrv_estadisticas_pagina_origen, fecha_impresion from n5_adsrv_estadisticas_detalle";
	
			$rsstats = mysqli_query($connexion, $query);
			while($fila = mysqli_fetch_array($rsstats)) {
				// tratamiento de parametros de la url
				
				$pagina_origen = substr($fila[2],strpos($fila[2],"?f=")+3,strlen($fila[2]));
				
				$pagina_origen = str_replace("?","&",$pagina_origen);
				$arrPars = explode("&",$pagina_origen);
				
				$topic = 0;
				if (count($arrPars[0]) > 0){
					$foro = $arrPars[0];
					
					if ( strpos($arrPars[1], "id") == null && strpos($arrPars[1], "t=")==0){
						$topic = substr($arrPars[1], 2, strlen($arrPars[1]));
					}else{
						$topic = 0;
					}
				}else{
					$foro = $arrPar[0];
					$topic = 0;
				}
				
				if ($topic == "") $topic = 0;
				
				$foro = str_replace("ros/viewtopic.php","",$foro);
				$foro = str_replace("ros/viewforum.php","",$foro);
				$fecha_date = substr($fila[3],0,10);
				$fecha_hora = substr($fila[3],11,8);
				$arrFechas = explode("/",$fecha_date);
				$fechaDefinitiva = $arrFechas[2]."-".$arrFechas[1]."-".$arrFechas[0]." ".$fecha_hora;
				
				$query = "INSERT INTO n4_adsrv_estadisticas (bannerID, empresaID, foroID, topicID, fecha)
							VALUES (".$fila[0].",".$fila[1].",".$foro.",".$topic.",'".$fechaDefinitiva."')";
				//$rsbanner = mysqli_query($connexion, $query);
			}
			
	
		}catch (Exception $ex){
			echo "Error: bannerDAO.grabarNuevoBanner";
			return null;
		}
	}
?>

