<?php
	require_once(__DIR__ . "/../lan/es.inc");
	require_once(__DIR__ . "/../../includes/conexion.inc");
	
	// cargamos los DAO
	require_once(__DIR__ . "/../DAO/bannerDAO.php");
	require_once(__DIR__ . "/../DAO/empresaDAO.php");
	require_once(__DIR__ . "/../DAO/usuarioDAO.php");
	require_once(__DIR__ . "/../DAO/estadisticasDAO.php");
	
	// cargamos los controller
	require_once(__DIR__ . "/../Controller/bannerController.php");
?>