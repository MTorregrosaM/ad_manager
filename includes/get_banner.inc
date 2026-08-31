<?php 

require_once(__DIR__ . "/conexion.inc");

// Obtenemos la id de las empresas que no se han publicado
$empresas_disponibles = mysqli_query($connexion, "SELECT empresaID FROM n4_adsrv_banners A INNER JOIN n4_adsrv_empresas B on A.empresaID =B.id where A.publicado = 0 AND A.estado = 1 and B.activo = 1 LIMIT 1");

if (mysqli_num_rows($empresas_disponibles) == 0) {

    // Si todas están marcadas como PUBLICADO = 1, las desmarcamos y recuperamos una de ellas
    $update_estado = "UPDATE n4_adsrv_banners SET publicado = 0";
    mysqli_query($connexion, $update_estado) or die(mysqli_error($connexion));
    $empresas_disponibles = mysqli_query($connexion, "SELECT min(id) as empresaID FROM n4_adsrv_empresas WHERE activo = 1");
}

while ($fila = mysqli_fetch_assoc($empresas_disponibles)) {
    $id_empresa = $fila['empresaID'];
}

// recuperamos uno de los banners de la empresa que no se haya publicado antes
$nuevo_banner = mysqli_query($connexion,"SELECT id
								from n4_adsrv_banners
								where n4_adsrv_banners.empresaID = ".$id_empresa."  
								and activo = 1 and estado = 1
								and publicadoEmpresa = 0
								group by id
								limit 1");

// si no recuperamos ninguno, reseteamos y tomamos uno
if (mysqli_num_rows($nuevo_banner) == 0){
	$update_estado = ("UPDATE n4_adsrv_banners
						SET publicadoEmpresa = 0
						WHERE empresaID = ".$id_empresa);
	
    mysqli_query($connexion,$update_estado) or die(mysqli_error($connexion));
	$nuevo_banner = mysqli_query($connexion,"SELECT id
								from n4_adsrv_banners
								where n4_adsrv_banners.empresaID = ".$id_empresa."  
								and activo = 1 and eliminado = 0 and estado = 1
								and publicadoEmpresa = 0
								group by id
								limit 1");
}


while ($fila = mysqli_fetch_assoc($nuevo_banner)){
	$id_nuevo_banner = $fila["id"];
}

if ($id_nuevo_banner == null){
    $id_nuevo_banner = 1;
}

// lo pintamos
$info_banner = mysqli_query($connexion,"SELECT * 
							FROM n4_adsrv_banners
							WHERE id = ".$id_nuevo_banner."
							AND activo = 1");
if ($info_banner!=null){
    while ($fila = mysqli_fetch_assoc($info_banner)){
            echo("<form action=\"../publicidad/set_stats.php\" method=\"POST\" id=\"stats\" target=\"_blank\">\n");
            echo("<input type=\"hidden\" name=\"id_banner\" value=\"".$fila['id']."\"/>\n");
            echo("<input type=\"hidden\" name=\"id_empresa\" value=\"".$fila['empresaID']."\"/>\n");
            echo("<input type=\"hidden\" name=\"url\" value=\"".$fila['url']."\"/>\n");
            //echo("<input type=\"hidden\" name=\"url_origen\" value=\"".$_SERVER['REQUEST_URI']."\"/>\n");
            //echo("<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\"/>\n");
            //printf("<a href=\"#\" title=\"".$fila['descripcion']."\" onClick(document.getElementById('stats').submit(););>");
            echo("<input type=\"image\" src=\"http://www.wargames-spain.com/publicidad/banners/".$fila['imagen']."\"\n border=\"0\" title=\"".$fila['descripcion']."\"/>\n");
            echo("</form>");
    }

    // grabamos estadisticas
    $insert_stats = ("UPDATE n4_adsrv_estadisticas_resumen
                                                    SET impresiones = (impresiones+1)
                                                    WHERE bannerID = ".$id_nuevo_banner."
                                                    AND empresaID = ".$id_empresa);

    mysqli_query($connexion,$insert_stats) or die(mysqli_error($connexion));

    $update_estado = ("UPDATE n4_adsrv_banners
                                            SET publicado = 1
                                            WHERE empresaID = ".$id_empresa." and estado = 1");

    mysqli_query($connexion,$update_estado) or die(mysqli_error($connexion));

    $update_estado = ("UPDATE n4_adsrv_banners 
                                            SET publicado = 1, publicadoEmpresa = 1
                                            WHERE id = ".$id_nuevo_banner." and estado = 1");

    mysqli_query($connexion,$update_estado) or die(mysqli_error($connexion));
}
?>