<?php 
	require_once(__DIR__ . "/includes/config.inc");

	$funcion 	= $_REQUEST['fun'];	
	$usuario 	= $_REQUEST['usuario'];
	$banner 	= $_REQUEST['bannerID'];
	$activo 	= $_REQUEST['activo'];
	$estado 	= $_REQUEST['estado'];
	$fechaIni	= $_REQUEST['fechaIni'];
	$fechaFin	= $_REQUEST['fechaFin'];
	switch ($funcion){
		case "actualizarBannerActivo":
			// actualizamos la marca de activo
			actualizarBannerActivo($banner,$usuario,$estado,$activo);
			mostrarListaBanners($usuario);			
			
			break;
		case "actualizarBannerEstado":
			// actualizamos la marca de estado
			actualizarBannerEstado($banner,$usuario,$estado,$activo);
			mostrarListaBanners($usuario);
			break;
		case "eliminarBanner":
			// actualizamos la marca de estado
			eliminarBanner($banner,$usuario);
			mostrarListaBanners($usuario);
			break;
	}
	
	

?>