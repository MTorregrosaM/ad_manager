<?php

	// recuperamos configuracion
	require_once(__DIR__ . '/config.inc');

	// conexion
	$connexion = mysqli_connect($host, $user, $pass, $db);

	// Verificar la conexión
	if (!$connexion) {
		die("Connection failed: " . mysqli_connect_error());
	}

	

?>