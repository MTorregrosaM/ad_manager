<?php 

require_once(__DIR__ . "/includes/conexion.inc");

$p_empresa_id = $_POST['id_empresa'];
$p_banner_id  = $_POST['id_banner'];
$p_url = $_POST['url'];
if (strpos($_POST['url'], 'http://') === false && strpos($_POST['url'], 'https://')=== false ){
	$p_url = 'http://'.$p_url ;
}
$p_url_origen = $_POST['url_origen'];
$topicID 	  = ($_POST['t'] != "")? $_POST['t'] : 0;
$foroID		  = ($_POST['f'] != "")? $_POST['f'] : 0;
echo $p_url;
$hoy = date("Y-m-d H:i:s");

// grabamos estadisticas
/*
$updateStats = ("UPDATE n4_adsrv_estadisticas_resumen
					SET clicks = (clicks+1)
					WHERE bannerID = ".$p_banner_id."
					AND empresaID = ".$p_empresa_id);

mysqli_query($connexion, $updateStats) or die(mysqli_error($connexion));

echo "INSERT INTO n4_adsrv_estadisticas (bannerID, empresaID, foroID, forumID, fecha_impresion)
							VALUES (".$p_banner_id.",".$p_empresa_id.",".$foroID.",".$topicID.",'".$hoy."')";

// estadsticas detalladas
$updateStats_detalladas = ("INSERT INTO n4_adsrv_estadisticas (bannerID, empresaID, foroID,topicID, fecha)
							VALUES (".$p_banner_id.",".$p_empresa_id.",".$foroID.",".$topicID.",'".$hoy."')");
mysqli_query($connexion, $updateStats_detalladas) or die(mysqli_error($connexion));
*/
header('Location: '.$p_url);

?>