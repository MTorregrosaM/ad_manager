<?php 
	require_once(__DIR__ . "/check_usuario.php");
	require_once(__DIR__ . "/includes/config.inc");
	define("USUARIO", $_SESSION['usuario']);
	
	$oEmpresa = getEmpresa (USUARIO);
	$error = false;
	
	// validamos que las fechas sean correctas
	if ($_POST['fechaIni'] > $_POST['fechaFin'])
		$error = true;
	
	// tratamos las variables de fecha
	if (isset($_POST['envioForm']) && $_POST['envioForm'] == "s" && !$error){
		$_SESSION['fechaIni'] =  date('Y-m-d',mktime(0, 0, 0, substr($_POST['fechaIni'],3,2), substr($_POST['fechaIni'],0,2), substr($_POST['fechaIni'],6,4)));
		$_SESSION['fechaFin'] =  date('Y-m-d',mktime(0, 0, 0, substr($_POST['fechaFin'],3,2), substr($_POST['fechaFin'],0,2), substr($_POST['fechaFin'],6,4)));
		$fechaIni = $_POST['fechaIni'];
		$fechaFin = $_POST['fechaFin'];
	}else{
		$_SESSION['fechaIni'] = date('Y-m-d',mktime(0, 0, 0, date('m'), 1, date('Y')));
		$_SESSION['fechaFin'] = date('Y-m-d',mktime(0, 0, 0, date('m'), date('d'), date('Y')));
		$fechaIni = date('d-m-Y',mktime(0, 0, 0, date('m'), 1, date('Y')));;
		$fechaFin = date('d-m-Y',mktime(0, 0, 0, date('m'), date('d'), date('Y')));
	}
	
	// recuperamos los datos del resumen
	$diasRestar = date("d",date(strtotime("-1 days")));
	$diasRestar2 = date("d");
	$diasRestar2meses =  date("t",date(strtotime("-2 months") ));
	
	$resumenDiario = getResumenClicks(USUARIO, 'D');
	$resumenDiarioDiff = $resumenDiario['act']-$resumenDiario['ant'];
	$resumenDiarioDiff = ($resumenDiarioDiff > 0)? "+".$resumenDiarioDiff : $resumenDiarioDiff;
	$resumenDiarioDiffClass = ($resumenDiarioDiff > 0)? "resumen-green" : "resumen-red";	
	
	$resumenMes = getResumenClicks(USUARIO, 'M');
	$resumenMesDiff = $resumenMes['act']-$resumenMes['ant'];
	$resumenMesDiff = ($resumenMesDiff > 0)? "+".$resumenMesDiff : $resumenMesDiff;
	$resumenMesDiffClass = ($resumenMesDiff > 0)? "resumen-green" : "resumen-red";
	$resumenMes = getResumenClicks(USUARIO, 'M');
	
	$resumenTotal = getResumenClicks(USUARIO, 'T');
	$resumenTotalFecha = $resumenTotal['ant']." / ".date('d-m-Y');
	$resumenTotalClicks = $resumenTotal['act'];
	
	$resumen = getResumenClicks(USUARIO, 'F',$_SESSION['fechaIni'], $_SESSION['fechaFin']);
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-en">

<head>
<title>Estad&iacute;sticas - Bonos de guerra - Wargames Spain</title>
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="styles/n4_adsrv.css"/>
<link rel="stylesheet" type="text/css" href="styles/n4_stats.css"/>
<link rel="stylesheet" type="text/css" href="styles/eggplant/jquery-ui-1.8.22.custom.css"/>
<script type="text/javascript">
	

	$(function() {
		// Tabs
		$('#tabs').tabs();

		
		$( "#fechaIni" ).datepicker({ 
			monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
			dateformat: 'dd-mm-yy',
			firstDay: 1,
			dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
			dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
			dateFormat: "dd-mm-yy"  });

		$( "#fechaFin" ).datepicker({ 
			monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
			dateformat: 'dd-mm-yy',
			firstDay: 1,
			dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
			dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
			dateFormat: "dd-mm-yy"  });

		$( "#btnFiltrar" ).button();
		$( "#btnFiltrar" ).click(function() { return false; });
	});
	</script>
</head>

<body>

<div id="body">
	<?php
		require_once(__DIR__ . "/includes/header.inc");
		require_once(__DIR__ . "/includes/menu.inc");
	?>
	
	<div id="contenido">
		<br/>
		<!-- Tabs -->
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Resumen intervalo seleccionado</a></li>
				<li><a href="#tabs-2">Hoy</a></li>
				<li><a href="#tabs-3">Mes</a></li>
				<li><a href="#tabs-4">Resumen global</a></li>
			</ul>
			<div id="tabs-1">
				<div>
					<table class="resumenStats">
						<tr>
							<th>Periodo</th>
							<th>Clicks</th>
						</tr>
						<tr>
							<td class="center"><?php echo $fechaIni." / ".$fechaFin?></td>
							<td class="center">
								<?php echo $resumen;?>
							</td>
						</tr>
						<tr><td></td><td>&nbsp;</td></tr>
					</table>
		    	</div>
			</div>
			<div id="tabs-2">
				<div>
					<table class="resumenStats">
						<tr>
							<th>Periodo</th>
							<th>Clicks</th>
						</tr>
						<tr>
							<td class="center"><?php echo date('d-m-Y')?></td>
							<td class="center">
								<?php echo $resumenDiario['act'];?>
								<span class="<?php echo $resumenDiarioDiffClass;?>">(<?php echo $resumenDiarioDiff;?>)</span>
							</td>
						</tr>
						<tr class="resumen-periodo-ant">
							<td class="center"><?php echo date('d-m-Y', time()-(24*60*60));?></td>
							<td class="center"><?php echo $resumenDiario['ant'];?></td>
						</tr>
					</table>
		    	</div>
		    </div>
			<div id="tabs-3">
				<div>
					<table class="resumenStats">
						<tr>
							<th>Periodo</th>
							<th>Clicks</th>
						</tr>
						<tr>
							<td class="center"><?php echo date("d-m-Y",strtotime("-".$diasRestar." days"))." / ".date('d-m-Y')?></td>
							<td class="center">
								<?php echo $resumenMes['act'];?>
								<span class="<?php echo $resumenMesDiffClass;?>">(<?php echo $resumenMesDiff;?>)</span>
							</td>
						</tr>
						<tr class="resumen-periodo-ant">
							<td class="center"><?php echo "01".date("-m-Y",strtotime("-1 months"))." / "
														 . date("d-m-Y",strtotime("last months"));?></td>
							<td class="center"><?php echo $resumenMes['ant'];?></td>
						</tr>
					</table>
					
		    	</div>
			</div>
			<div id="tabs-4">
				<div>
						<table class="resumenStats">
							<tr>
								<th>Periodo</th>
								<th>Clicks</th>
							</tr>
							<tr>
								<td class="center"><?php echo $resumenTotalFecha?></td>
								<td class="center">
									<?php echo $resumenTotalClicks;?>
								</td>
							</tr>
							<tr><td></td><td>&nbsp;</td></tr>
						</table>
			    	</div>
			</div>
		</div>

		<?php if ($error) { ?><div id="errores" class="block"><p>Por favor, seleccione otro intervalo de fecha.</p></div><?php } ?>
		<div class="filtro-fechas">
			<form name="filtroEstadisticas" id="filtroEstadisticas" method="post">
				<a href="#" class="btn-form" onClick="document.filtroEstadisticas.submit()">Filtrar</a>
				<div class="right">
					Intervalo de fechas: 
					<input type="text" id="fechaIni" name="fechaIni" size="10" value="<?php echo $fechaIni;?>" class="inputFecha"/> - 
					<input type="text" id="fechaFin" name="fechaFin" size="10" value="<?php echo $fechaFin;?>" class="inputFecha"/>
					<input type="hidden" name="envioForm" id="envioForm" value="s"/>
				</div>
			</form>
		</div>
		
		<?php
	 		require_once 'includes/class.eyedatagrid.inc.php';
			EyeDataGrid::useAjaxTable('includes/statsAdmin.inc.php');
 		 ?>
	</div>
	<?php
		require_once(__DIR__ . "/includes/footer.inc");
	?>
</div>
</body>
</html>