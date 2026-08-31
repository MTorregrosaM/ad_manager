<?php 
session_start();
    if (isset($_SESSION['logado'])){ header("Location: n4_banners.php");
       
    }
    
    
	require_once(__DIR__ . "/includes/config.inc");

	// variables
	$classUser = "inputNormal";
	$classPass = "inputNormal";
	
	// vemos si se ha intentado logar
	if (isset($_POST['validador'])){
		$username = $_POST['admUsuario'];
		$password = $_POST['admPassword'];
		// validamos campos
		if (strlen($username) == 0){
			$classUser = "inputError";
			$error = true;
		}
		if (strlen($password) == 0){
			$classPass = "inputError";
			$error = true;
		}
		
		// si no hay errores previos, validamos que el usuario y clave coinciden con la BD
		if(!$error){
			$oUsuario = validarAcceso($username, $password);
			
			if ($oUsuario != null){
				// se ha logado correctamente
				session_start();
	            $_SESSION["logado"] = true;
	            $_SESSION["usuario"] = $oUsuario->getId();
	            // grabamos ultimo acceso
	            grabarUltimoAcceso($oUsuario->getId());
	            header("Location: n4_banners.php");
			}else{
				$classUser = "inputError";
				$classPass = "inputError";
				$error = true;
			}
		}
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">
<head>
<title>Bonos de guerra - Wargames Spain</title>
<meta name="robots" content="NOINDEX,NOFOLLOW" />

<script type="text/javascript" src="js/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="styles/n4_adsrv.css"/>

</head>

<body>

<div id="body">
	<?php
		require_once(__DIR__ . "/includes/header.inc");
	?>
	<div id="contenido">
		<h1>Acceso al sistema</h1>
		
		<?php if ($error) {?>
			<div id="errores" class="block"><p>Error al intentar acceder, revisa los campos por favor.</p></div>
		<?php } ?>
		
		<fieldset class="fieldset">
			<legend>Login</legend>
			<form id="formlogin" name="formlogin" method="post">
				<input type="hidden" name="validador" value="0"/>
				<label class="labelBold">Usuario:</label></label><input type="text" name="admUsuario" class="<?php echo $classUser;?>" value="<?php echo $username;?>"/><br/>
				<label class="labelBold">Contrase&ntilde;a: </label><input type="password" name="admPassword" class="<?php echo $classPass;?>" value="<?php echo $password;?>"  onkeypress="iSubmitEnter(event, document.formlogin)"/><br/>
				<a href="#" class="btnSubmit boton btnLogin" onClick="document.formlogin.submit();">Entrar</a>
			</form>
		</fieldset>
	</div>
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>