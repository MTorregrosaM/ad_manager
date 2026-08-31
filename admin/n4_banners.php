<?php 
	require_once(__DIR__ . "/check_usuario.php");
	require_once(__DIR__ . "/includes/config.inc");
	define("USUARIO", $_SESSION['usuario']);
	
	// variables
	$grabar = false;
	$errorTamano = false;
	$oEmpresa = getEmpresa(USUARIO);
	
	$estado = 1;
	// recibimos params
	$modo = (isset($_POST['modo']))? $_POST['modo'] : "";
	if ($modo == "alta"){
		$msjCabecera =  " &raquo; Alta de nuevo banner";
		$msjFieldset = "Nuevo banner";
		$msjOK = "Se ha dado de alta correctamente el banner";
		
		// si se ha enviado el alta de un nuevo banner, lo tramitamos
		if (isset($_POST['accion']) && $_POST['accion'] == "grabar"){
			// recuperamos los campos del formulario
			$nombre 	 = $_POST['nombre'];
			$url 		 = str_replace("http://","",$_POST['url']);
			$estado = $_POST['estado'];
			$estado_txt = ($estado == 1)? "Activada" : "En pausa";
			$descripcion = $_POST['descripcion'];
			// tratamiento del fichero
			$tipo_archivo   = $_FILES [ 'imagen' ] [ 'type' ];
			$tamano_archivo = $_FILES [ 'imagen' ] [ 'size' ];
			$nombre_temp    = $_FILES [ 'imagen' ] [ 'tmp_name' ];
			
			// comprobamos que no pese mas de 150kb, si no, avisamos del error
			list($ancho, $alto, $tipo, $atributos) = getimagesize($nombre_temp);
			
			if ($tamano_archivo/1024 > 150 || $ancho != 468 || $alto != 60){
				$errorTamano = true;
			}else{
				$extension      = str_replace("image/","",$_FILES [ 'imagen' ] [ 'type' ]);
				$extension      = ($extension == "" || !isset($extension) || $extension == null)? "jpeg" : $extension;
				
				$arr_extensiones = array (
	                                       "jpeg" => ".jpg",
                                       "gif"  => ".gif",
                                       "bmp"  => ".bmp",
                                       "png"  => ".png"
								     );
				$imagen_banner = "banner_".strtolower($oEmpresa->getEmpresa()).getUltimoIdBannerEmp(USUARIO).$arr_extensiones[$extension];
				$file_path     = "../banners/".$imagen_banner;
				copy($_FILES [ 'imagen' ] [ 'tmp_name' ], $file_path);
				
				// guardamos los datos
				grabarNuevoBanner($nombre, $imagen_banner, $url, $estado, $descripcion, USUARIO);
				
				$grabar = true;
			}	
		}
	}elseif($modo == "editar"){
		$msjCabecera = " &raquo; Modificaci&oacute;n de banner";
		$msjFieldset = "Modificar banner";
		$msjOK = "Se ha modificado correctamente el banner";
		
		$bannerID = $_POST['bannerID'];
		
		$oBanner = getBanner($bannerID);
		// recuperamos los campos del formulario
		$nombre 	 = $oBanner->getNombre();
		$url 		 = $oBanner->getUrl();
		$estado = $oBanner->getEstado();
		$descripcion = $oBanner->getDescripcion();
		$imagen_banner 	 = $oBanner->getImagen();
		
		if (isset($_POST['accion']) && $_POST['accion'] == "grabar"){
			// recuperamos los campos del formulario
			$nombre 	 = $_POST['nombre'];
			$url 		 = str_replace("http://","",$_POST['url']);
			$estado = $_POST['estado'];
			$estado_txt = ($estado == 1)? "Activada" : "En pausa";
			$descripcion = $_POST['descripcion'];
			// tratamiento del fichero
			$tipo_archivo   = $_FILES [ 'imagen' ] [ 'type' ];
			$tamano_archivo = $_FILES [ 'imagen' ] [ 'size' ];
			$nombre_temp    = $_FILES [ 'imagen' ] [ 'tmp_name' ];
				
			// comprobamos que no pese mas de 150kb, si no, avisamos del error
			list($ancho, $alto, $tipo, $atributos) = getimagesize($nombre_temp);
				
			if ($tipo_archivo != "" && ($tamano_archivo/1024 > 150 || $ancho != 468 || $alto != 60)){
				$errorTamano = true;
			}else{
			
				if ($tipo_archivo != ""){
					$extension      = str_replace("image/","",$_FILES [ 'imagen' ] [ 'type' ]);
					$extension      = ($extension == "" || !isset($extension) || $extension == null)? "jpeg" : $extension;
				
					$arr_extensiones = array (
					                                   "jpeg" => ".jpg",
				                                       "gif"  => ".gif",
				                                       "bmp"  => ".bmp",
				                                       "png"  => ".png"
					);
					
					// borramos la foto antigua y generamos la nueva:
					if (file_exists("../banners/".$imagen_banner)){
						unlink ("../banners/".$imagen_banner);
					}
					
				
					if (USUARIO == -999) { $oEmpresa = getEmpresa($_POST['empresaID']); }
					
					$imagen_banner = "banner_".strtolower($oEmpresa->getEmpresa()).$bannerID.$arr_extensiones[$extension];
					$file_path     = "../banners/".$imagen_banner;
					
					copy($_FILES [ 'imagen' ] [ 'tmp_name' ], $file_path);
				}
				// guardamos los datos
				grabarActualizacionBanner($nombre, $imagen_banner, $url, $estado, $descripcion, USUARIO, $bannerID);
			
				$grabar = true;
			}
		}
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">

<head>
<title>Banners - Bonos de guerra - Wargames Spain</title>
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/funciones.js"></script>
<link href="https://www.wargames-spain.com/publicidad/admin/styles/n4_adsrv.css" rel="stylesheet" type="text/css" title="Default Styles" media="screen"/>

</head>

<body>

<div id="body">
	<?php
		require_once(__DIR__ . "/includes/header.inc");
		require_once(__DIR__ . "/includes/menu.inc");
		
	?>
	<div id="contenido">
		<h1>Banners <?php echo $msjCabecera;?></h1>
		<?php if ($modo == "alta" || $modo == "editar") {?>
			
			<?php if ($grabar){  ?>
				<div id="okGrabar"><p><?php echo $msjOK;?>. Pulsa <a href="n4_banners.php"><b>aqu&iacute;</b></a> para volver al panel de Banners.</p>
				</div>
				<div class="msj-perfil-100">Revisa el link del banner, &iquest;Funciona correctamente?</div>
						 	
				<fieldset class="fieldset">
				<legend>Vista previa del nuevo banner</legend>
					<div class="perfil-total">
						<label class="labelBold">Banner:</label><a href="http://<?php echo $url;?>" target="blank"><img src="../banners/<?php echo $imagen_banner;?>" border="0"/></a><br/><br/>
					</div>
					<div class="perfil-left">
						<label class="labelBold">Nombre:</label> <label class="lbl-txt"><?php echo $nombre?></label><br/><br/>
						<label class="labelBold">URL destino:</label> <label class="lbl-txt"><?php echo $url?></label><br/><br/>
						<label class="labelBold">Publicaci&oacute;n:</label> <label class="lbl-txt"><?php echo $estado_txt?></label>
					</div>
					<div class="perfil-left">
						<label class="labelBold">Descripci&oacute;n:</label> <label class="lbl-txt lbl-desc"><?php echo $descripcion?></label>
					</div>
				</fieldset>
				
			<?php }else{ ?>
				
				<div id="errores">
					<p>Error, por favor, revisa los campos marcados en rojo. 
						<span class="oculto" id="errorExtension">Extensi&oacute;n de imagen no v&aacute;lida</span>
					</p>
				</div>
				<?php if ($errorTamano){ ?>
				<div id="erroresFile">
					<p>Error, la imagen no puede tener un tama&ntilde;o mayor de 150kb y sus dimensiones deben ser 468 x 60px. </p>
				</div>
				<?php }?>
				
				
				<!-- FORMULARIO DE ALTA DE NUEVO BANNER -->
				<fieldset class="fieldset">
					<legend><?php echo $msjFieldset;?></legend>
					<form name="grabarNuevoBanner" method="post" enctype="multipart/form-data">
						<input type="hidden" name="modo" value="<?php echo $modo;?>"/>
						<input type="hidden" name="accion" value="grabar"/>
						<input type="hidden" name="empresaID" value="<?php echo $_POST['empresaID'];?>"/>
						<?php if ($modo == "editar") printf("<input type=\"hidden\" name=\"bannerID\" value=\"".$bannerID."\"/>");?>
						<div class="perfil-left">
							<label class="labelBold">Nombre:</label> <input type="text" name="nombre" id="nombre" value="<?php echo $nombre?>" size="50"/>
							<label class="labelBold">URL destino:</label> <input type="text" name="url" id="url" value="<?php echo $url?>" size="50"/>
							<label class="labelBold">Publicaci&oacute;n:</label> 
								<select name="estado" id="estado">
									<option value="1" <?php if ($estado == 1 ) printf("selected");?>>Activada</option>
									<option value="0" <?php if ($estado == 0) printf("selected");?>>En pausa</option>
								</select>
						</div>
						<div class="perfil-left">
							<label class="labelBold">Descripci&oacute;n:</label> <textarea name="descripcion" id="descripcion" cols="46" rows="3" maxlength="150"><?php echo $descripcion?></textarea>
						</div>
						<div class="perfil-total">
						<br/><br/>
						 	<div class="msj-perfil">La imagen debe tener unas dimensiones de 468 x 60px; el peso debe ser igual o menor a 150kb y de extensi&oacute;n .JPG, .GIF, .PNG &oacute; .BMP:</div>
						 	<div class="logo-editar"><?php if ($modo == "editar") { printf("<img src=\"../banners/".$imagen_banner."\" />"); } ?></div>
						 	<input type="hidden" name="MAX_FILE_SIZE" value="1500000"/>
	                        <label class="labelBold">Imagen:</label> <input name="imagen" id="imagen" type="file" value="<?echo $_FILES [ 'imagen' ];?>" size="50"/>
						</div>
						<a href="#"  class="btnSubmit boton" onClick="validarFormAltaBanner('<?php echo $modo;?>');">Grabar</a>
					</form>
				</fieldset>
			<?php } ?>
		<?php }elseif($modo == "editar"){?>
			<!-- FORMULARIO DE MODIFICACION DE BANNER -->
			
		<?php }else{ ?>
			<!-- LISTADO DE BANNERS -->
			<div id="box-banners">
				<?php mostrarListaBanners (USUARIO);?>
			</div>
			
			<?php if (USUARIO != -999){?>
				<div id="btnAltaBanner">
					<form method="post" name="formAltaNuevo">
						<input type="hidden" name="modo" value="alta"/>
						<a href="#"  class="btnSubmit boton" onClick="document.formAltaNuevo.submit();">Alta de nuevo banner</a>
					</form>
				</div>
			<?php }?>
			
			<div id="leyenda">
				<h2>Leyenda</h2>
				
				<ul>
					<li><img src="images/activo.png"/> Banner activado</li>
					<li><img src="images/inactivo.png"/> Banner desactivado</li>
				</ul>
				<ul>
					<li><img src="images/play.png"/> Publicaci&oacute;n del banner activa</li>
					<li><img src="images/pause.png"/> Publicaci&oacute;n del banner detenida</li>
				</ul>
				<ul>
					<li><img src="images/edit.png"/> Modificar banner</li>
					<li><img src="images/false.png"/> Eliminar banner</li>
				</ul>
				<div class="msj-leyenda">
					<p>Configuraci&oacute;n r&aacute;pida: puedes hacer click sobre los iconos de cada banner para agilizar la configuraci&oacute;n de los banners.</p>
				</div>
			</div>
		
		<?php } ?>
	
	</div>
	
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>