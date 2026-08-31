<?php 
	require_once(__DIR__ . "/check_usuario.php");
	require_once(__DIR__ . "/includes/config.inc");
	
	define("USUARIO", $_SESSION['usuario']);
	
	$oEmpresa = getEmpresa (USUARIO);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">

<head>
<title>Datos de abono - Bonos de guerra - Wargames Spain</title>
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
		<h1>Abonos</h1>
		<p>Datos para realizar los abonos mensuales:</p>
		<div class="msj-pagos">
			<label class="lbl-bold">Nombre:</label> <label class="lbl-txt">Asoc Wargames Spain</label><br/><br/>
			<label class="lbl-bold">Banco:</label> <label class="lbl-txt">Bankia</label><br/><br/>
			<label class="lbl-bold">Cuenta:</label> <label class="lbl-txt">2038 5700 1260 0337 5103</label><br/><br/>
			<label class="lbl-bold">Concepto:</label> <label class="lbl-txt">WGS-<?php echo $oEmpresa->getEmpresa();?></label><br/><br/><br/><br/>
			<label class="lbl-bold">Paypal:</label> <label class="lbl-txt">sumeru87@gmail.com</label><br/><br/>
		</div>
						 	
	</div>
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>