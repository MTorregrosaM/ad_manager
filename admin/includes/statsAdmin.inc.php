<?php 
require __DIR__ . '/class.eyemysqladap.inc.php';
require __DIR__ . '/class.eyedatagrid.inc.php';
require_once(__DIR__ . "/../../includes/config.inc");


/* RESUMEN */
/****************************************************************************/
echo "<div class=\"div-resumen-stats\">";

echo "</div>";


/* TABLA DE DATOS */
/****************************************************************************/
// Load the database adapter
$db = new EyeMySQLAdap($host, $user, $pass, $db);
				
	
// Load the datagrid class
$x = new EyeDataGrid($db);

session_start();
$usuario =  $_SESSION['usuario'];
$fechaIni = $_SESSION['fechaIni'];
$fechaFin = $_SESSION['fechaFin'];

// montamos la query
$select .= " CONCAT('<a href=\"http://',ban.url,'\" target=\"blank\"><img src=\"../banners/',ban.imagen,'\" width=\"150px\" border=\"0\"></a>') as Banner,  ";
$select .= " ban.nombre as Nombre , fecha as Fecha, ";
$select .= " CASE WHEN length(foro.forum_name) > 20 THEN CONCAT(substr(foro.forum_name,1,20),'...') ELSE foro.forum_name END as Foro, ";
$select .= " topicID as Mensaje, ";
$select .= " CASE WHEN topicID != 0 THEN concat('<a href=\"http://www.wargames-spain.com/foros/viewtopic.php?f=',foroID,'&t=',topicID,'\" target=\"blank\"><img src=\"images/world_link.png\"/> Ver link</a>') ";
$select .= " ELSE concat('<a href=\"http://www.wargames-spain.com/foros/viewforum.php?f=',foroID,'\" target=\"blank\"><img src=\"images/world_link.png\"/> Ver link</a>') END  as Origen";


$from  = " n4_adsrv_estadisticas est ";
$from .= " LEFT OUTER JOIN n4_adsrv_empresas emp ON est.empresaID = emp.id ";
$from .= " JOIN n4_adsrv_banners ban ON est.bannerID = ban.id AND ban.empresaID = est.empresaID ";
$from .= " JOIN phpbb_forums foro ON foro.forum_id = est.foroID ";
$where = " 1=1 ";
$where .= ($usuario != -999)? " AND est.empresaID = ".$usuario : "";
$where .= " AND fecha >= '".$fechaIni."' and fecha <= date_add('".$fechaFin."', INTERVAL 1 DAY)";

// Set the query
$x->setQuery($select, $from,"",$where);


$x->printTable();

	
	

?>