<?php 
	require_once(__DIR__ . "/check_usuario.php");
	require_once(__DIR__ . "/includes/config.inc");
	
	define("USUARIO", $_SESSION['usuario']);
	
	
	// recuperamos los datos de la empresa para enviar el correo
	$oEmpresa = getEmpresa (USUARIO);
	$oUsuario = getUsuario (USUARIO);
	$passOk = false;
	
	
	if (isset($_POST['validador'])){
		// enviamos el correo
		$consulta = $_POST['consulta'];
		
		// enviamos el correo
		
		/* cabecera del email */
		$mail_header = "MIME-Version: 1.0\r\n";
		$mail_header .= "Content-type: text/html; charset=utf-8\r\n";
		$mail_header .= "From: Wargames Spain <publicidad@wargames-spain.com>\r\n";
		$mail_header .= "Bcc: nagash87@gmail.com\r\n";
	
		$mail_destino = $oUsuario->getEmail();
		$mail_titulo = "Consulta publicidad Wargames Spain";
	
		$mail_body = "Se ha enviado correctamente tu consulta desde el panel de administraci&oacute;n de publicidad de Wargames Spain. Trataremos de responderte con la mayor brevedad.<br/>";
		$mail_body .= "<ul><li><strong>Empresa:</strong> ".$oEmpresa->getEmpresa()."</li>";
		$mail_body .= "<li><strong>Usuario:</strong> ".$oUsuario->getNombre()." ".$oUsuario->getApellidos()."</li>";
		$mail_body .= "<li><strong>Email:</strong> ".$oUsuario->getEmail()."</li>";
		$mail_body .= "<li><strong>Consulta:</strong> ".$consulta."</li></ul><br/>";
		$mail_body .= "<p>Un cordial saludo,<br/>Wargames Spain</p>";
		$mail_body .= "<p><a href=\"http://www.wargames-spain.com/publicidad/admin\">Wargames Spain Publicidad</a>";
	
		/* enviamos el email */
		mail($mail_destino,$mail_titulo,$mail_body,$mail_header);
	
		$passOk = true;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">
<head>
<title>Contacto - Bonos de guerra - Wargames Spain</title>
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="styles/n4_adsrv.css"/>

</head>

<body>

<div id="body">
	<?php
		require_once(__DIR__ . "/includes/header.inc");
		require_once(__DIR__ . "/includes/menu.inc");
	?>
	<div id="contenido">
		<h1>Contacto</h1>
		
		<div id="avisosOK">
			<?php if ($passOk){ ?>
				<div id="ok"><p>Se ha enviado la consulta correctamente.</p></div>
			<?php }else{ ?>
			
		</div>
		<div id="errores"><p>No se puede enviar la consulta vac&iacute;a</p></div>
	
		<p>&iquest;Si tienes alguna duda? escr&iacute;benos un correo con los detalles de la misma.</p>
	 	<fieldset class="fieldset">
			<legend>Consulta</legend>
			<form name="formConsulta" method="post">
				<input type="hidden" name="validador" value="0"/>
				<textarea name="consulta" id="consulta" cols="150" rows="10" class="textarea"></textarea><br/><br/>
				<a href="#" class="btnSubmit boton" onClick="validarFormConsulta();">Enviar consulta</a>
			</form>
		</fieldset>
		<?php } ?>
	</div>
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>