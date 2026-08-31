<?php 

require_once(__DIR__ . "/conexion.inc");

// obtenemos la id de la ultima empresa
$ultima_empresa_anunciada = mysqli_query($connexion, "SELECT empresaID from n4_adsrv_banners where publicado = 1");
while($fila = mysqli_fetch_array($ultima_empresa_anunciada)) {
	$id_empresa = $fila[0];
}


// ahora vamos a recuperar un banner que no sea de esta empresa
$listado_empresas = mysqli_query($connexion, "SELECT id from n4_adsrv_empresas where id != ".$id_empresa." order by rand() limit 1");

if (mysqli_num_rows($listado_empresas) == 0)
{
	$listado_empresas = mysqli_query($connexion, "SELECT min(id) from n4_adsrv_empresas");
}

while ($fila = mysqli_fetch_array($listado_empresas)){
	$id_nueva_empresa = $fila[0];
}


// recuperamos uno de los banners de la empresa
$nuevo_banner = mysqli_query($connexion, "SELECT id
								from n4_adsrv_banners
								where n4_adsrv_banners.empresaID = ".$id_nueva_empresa."  
								and activo = 1 and eliminado = 0 and estado = 1
								group by id
								order by publicadoEmpresa ASC
								limit 1");

// si no recuperamos ninguno, quiere decir que no tiene ninguno activo, asi que tomamos otro de otra empresa
if (mysqli_num_rows($nuevo_banner) == 0){
	
	$nuevo_banner_rdm = mysqli_query($connexion, "SELECT id
											FROM n4_adsrv_banners
											WHERE 1=1
											AND activo = 1
											AND estado = 1										
											ORDER BY RAND()");
	
	while ($fila_rdm = mysqli_fetch_array($nuevo_banner_rdm)){
		$id_nuevo_banner = $fila_rdm[0];
	}	
}else{
	while ($fila = mysqli_fetch_array($nuevo_banner)){
		$id_nuevo_banner = $fila[0];
	}
}	
	

// lo pintamos
$info_banner = mysqli_query($connexion, "SELECT * 
							FROM n4_adsrv_banners
							WHERE id = ".$id_nuevo_banner."
							AND activo = 1");

while ($fila = mysqli_fetch_array($info_banner)){
	printf("<form action=\"../publicidad/set_stats.php\" method=\"POST\" id=\"stats\" target=\"_blank\">\n");
	printf("<input type=\"hidden\" name=\"id_banner\" value=\"".$fila['id']."\"/>\n");
	printf("<input type=\"hidden\" name=\"id_empresa\" value=\"".$fila['empresaID']."\"/>\n");
	printf("<input type=\"hidden\" name=\"url\" value=\"".$fila['url']."\"/>\n");
	printf("<input type=\"hidden\" name=\"url_origen\" value=\"".$_SERVER['REQUEST_URI']."\"/>\n");
	printf("<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\"/>\n");
	printf("<input type=\"hidden\" name=\"t\" value=\"".$_GET['t']."\"/>\n");
	//printf("<a href=\"#\" title=\"".$fila['descripcion']."\" onClick(document.getElementById('stats').submit(););>");
	printf("<input type=\"image\" src=\"http://www.wargames-spain.com/publicidad/banners/".$fila['imagen'].
		"\"\n border=\"0\" title=\"".$fila['descripcion']."\"/>\n");
	printf("</form>");
}


// grabamos estadisticas
$insert_stats = ("UPDATE n4_adsrv_estadisticas_resumen
						SET impresiones = (impresiones+1)
						WHERE bannerID = ".$id_nuevo_banner."
						AND empresaID = ".$id_nueva_empresa);

mysqli_query($connexion, $insert_stats) or die(mysqli_error($connexion));

$update_estado = ("UPDATE n4_adsrv_banners
					SET publicado = 0, publicadoEmpresa = 0
					WHERE empresaID = ".$id_nueva_empresa);
mysqli_query($connexion, $update_estado) or die(mysqli_error($connexion));

$update_estado = ("UPDATE n4_adsrv_banners
					SET publicado = 0");
mysqli_query($connexion, $update_estado) or die(mysqli_error($connexion));

$update_estado = ("UPDATE n4_adsrv_banners 
					SET publicado = 1, publicadoEmpresa = 1
					WHERE id = ".$id_nuevo_banner);
mysqli_query($connexion, $update_estado) or die(mysqli_error($connexion));


?>