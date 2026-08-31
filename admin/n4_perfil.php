<?php 
	require_once(__DIR__ . "/check_usuario.php");
	require_once(__DIR__ . "/includes/config.inc");
	
	define("USUARIO", $_SESSION['usuario']);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">

<head>
<title>Mis datos - Bonos de guerra - Wargames Spain</title>
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
		
		$passOk = false;
		$grabar = false;
		
		// recuperamos datos del formulario enviado
		
		if (isset($_POST['accion'])){
			switch ($_POST['accion']){
				// cambiamos la clave
				case "pass":
					$clave = $_POST['clave'];
					$clave2 = $_POST['clave2'];
					
					cambiarClave($clave, USUARIO);
					$passOk = true;
					break;
					
				// modificacion de datos
				case "modificar":
					$edit = true;
					break;
				// grabar de datos
				case "grabar":
					$nombre		= $_POST['nombre'];
					$calle		= $_POST['calle'];
					$numero 	= $_POST['numero'];
					$cp 		= $_POST['cp'];
					$telefono 	= $_POST['telefono'];
					$email 		= $_POST['email'];
					$web 		= $_POST['web'];
					
					actualizarDatosEmpresa($nombre, $calle, $numero, $cp, $telefono, $email, $web, USUARIO);
					
					$grabar = true;
					break;
			}
		}
	?>
	<div id="contenido">
		<h1>Mis datos</h1>
		<div id="avisosOK">
			<?php if ($passOk){ ?>
				<div id="ok"><p>Se ha cambiado la contrase&ntilde;a correctamente.</p></div>
			<?php } ?>
			<?php if ($grabar){ ?>
				<div id="okGrabar"><p>Se han actualizado los datos correctamente.</p></div>
			<?php } ?>
		</div>
		<div id="errores"><p>Error al intentar cambiar la clave de acceso, por favor, revise los campos.</p></div>
		
		<fieldset class="fieldset">
			<legend>Datos de empresa</legend>
			
			<form name="cambioDatos" method="post">
				<?php 
				
				$disable = (!isset($edit) && !$edit)? "disabled=\"disabled\"" : "";
				if ($edit){
					printf("<div class=\"msj-perfil\">Ahora puedes modificar cualquier campo:</div>");
				}
				// recuperamos los datos de la empresa
				$oEmpresa = getEmpresa(USUARIO); 
				printf("<div class=\"perfil-left\">");
				
				printf("<label class=\"labelBold\">Nombre:</label> <input type=\"text\" name=\"nombre\" ".$disable." value=\"".$oEmpresa->getEmpresa()."\" size=\"50\"/><br/>");
				printf("<label class=\"labelBold\">Calle:</label> <input type=\"text\" ".$disable." name=\"calle\" value=\"".$oEmpresa->getCalle()."\" size=\"50\"/><br/>");
				printf("<label class=\"labelBold\">N&uacute;mero:</label> <input type=\"text\" ".$disable." name=\"numero\" value=\"".$oEmpresa->getNumero()."\" size=\"50\"/><br/>");
				printf("<label class=\"labelBold\">CP:</label> <input type=\"text\" ".$disable." name=\"cp\" value=\"".$oEmpresa->getCodigo_Postal()."\" size=\"50\"/><br/>");
				printf("</div>");
				printf("<div class=\"perfil-right\">");
				printf("<label class=\"labelBold\">Telefono:</label> <input type=\"text\" ".$disable." name=\"telefono\" value=\"".$oEmpresa->getTelefono()."\" size=\"50\" maxlength=\"10\"/><br/>");
				printf("<label class=\"labelBold\">E-mail:</label> <input type=\"text\" ".$disable." name=\"email\" value=\"".$oEmpresa->getEmail()."\" size=\"50\"/><br/>");
				printf("<label class=\"labelBold\">Web:</label> <input type=\"text\" ".$disable." name=\"web\" value=\"".$oEmpresa->getWeb()."\" size=\"50\"/><br/>");
				printf("<label class=\"labelBold\">Fecha alta:</label> <input type=\"text\" disabled=\"disabled\" value=\"".$oEmpresa->getFecha_Alta()."\" size=\"50\"/><br/>");
				printf("</div>");
				
				?>
			<br/>
			
				<?php if ($edit) {?>
					<input type="hidden" name="accion" value="grabar"/>
					<a href="#"  class="btnSubmit boton" onClick="document.cambioDatos.submit();">Grabar</a>
				<?php }else{?>
					<input type="hidden" name="accion" value="modificar"/>
					<a href="#"  class="btnSubmit boton" onClick="document.cambioDatos.submit();">Modificar datos</a>
				<?php } ?>
			</form>
		</fieldset>
		
		<br/>
	
		<fieldset class="fieldset-clave">
			<legend>Datos de acceso</legend>
			<p>Desde aqu&iacute; puedes cambiar la clave de acceso a la aplicaci&oacute;n.</p>
			<form name="cambioPass" method="post" id="cambioPass">
				<input type="hidden" name="accion" value="pass"/>
				<div class="left">
					<label for="clave">Nueva contrase&ntilde;a</label> <input type="text" name="clave" id="clave" value="<?php echo $clave?>"/>
				</div>
				<div class="left">
					<label for="clave2">Repite la contrase&ntilde;a</label> <input type="text" name="clave2" id="clave2" value="<?php echo $clave2?>"/>
				</div>
				<a href="#" class="btnSubmit boton" onClick="validarFormPass();">Cambiar contrase&ntilde;a</a>
				
			</form>
		</fieldset>
	</div>
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>