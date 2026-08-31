<?php
function mostrarListaBanners ($usuario){
	printf("<table class=\"listado-banner\">
			<tr class=\"cabecera\">
			<th>Banner</th>
			");
	if ($usuario == -999){
		printf ("<th align=\"center\">Empresa</th>");
	}
	printf ("<th>Fecha Alta</th>
			<th>Clics</th>
			<th>Impresiones</th>
			<th>Activo</th>
			<th>Estado</th>
			<th>Operaciones</th></tr>");

	// PINTAMOS LOS ARRAYS
	$arrBanners = array();
	$arrBanners = getBanners($usuario);
		
	foreach ($arrBanners as $oBanner){
	
		// tratamiento previo
		$activo = ($oBanner->getActivo() == 1)? "activo.png" : "inactivo.png";
		if ($oBanner->getEstado() == 1 && $oBanner->getActivo() == 1){
			$estado = "play.png";
		}elseif ($oBanner->getEstado() == 0 && $oBanner->getActivo() == 1) {
			$estado = "pause.png";
			$activo = "ambar.png";
		}else{
			$estado = "stop.png";
		}
		// pintamos
		printf("<tr>");
		printf("<td width=\"500px\"><a href=\"http://".$oBanner->getUrl()."\" target=\"blank\"><img src=\"../banners/".$oBanner->getImagen()."\" border=\"0\" alt=\"Ver link\"/></a></td>");
		if ($usuario == -999){
			// recuperamos datos de empresa
			$oEmpresa =  getEmpresa($oBanner->getIdEmpresa());
			printf("<td align=\"center\">".$oEmpresa->getEmpresa()."</td>");
		}
		printf("<td align=\"center\">".substr($oBanner->getFechaAlta(),0,10)."</td>");
		printf("<td align=\"center\">".number_format(getClicksBanner($oBanner),0,",", ".")."</td>");
		printf("<td align=\"center\">".number_format(getImpresionesBanner($oBanner),0,",", ".")."</td>");
		printf("<td align=\"center\"><a href=\"#\" onclick=\"ActualizarActivo(".$oBanner->getId() .",'".$activo."',".$usuario.")\"><img src=\"images/".$activo."\" border=\"0\" alt=\"Verde: activado | Rojo: desactivado | Ambar: en pausa\" title=\"Verde: activado | Rojo: desactivado | Ambar: en pausa\"/></a></td>");
		printf("<td align=\"center\"><a href=\"#\" onclick=\"ActualizarEstado(".$oBanner->getId() .",'".$estado."',".$usuario.")\"><img src=\"images/".$estado."\" border=\"0\" alt=\"Play: activo | Pause: en pausa | Stop: detenido\" title=\"Play: activo | Pause: en pausa | Stop: detenido\"/></a></td>");
		printf("<td align=\"center\">
				<form method=\"post\" id=\"formEditar".$oBanner->getId()."\" name=\"formEditar".$oBanner->getId()."\" style=\"margin-top: 5px\" >
				<input type=\"hidden\" name=\"modo\" value=\"editar\"/>
				<input type=\"hidden\" name=\"bannerID\" value=\"".$oBanner->getId()."\"/>");
		if ($usuario == -999){
			printf("<input type=\"hidden\" name=\"empresaID\" value=\"".$oEmpresa->getId()."\"/>");
		}
		printf("<a href=\"#\" onClick=\"document.getElementById('formEditar".$oBanner->getId()."').submit();\">
				<img src=\"images/edit.png\" alt=\"Editar\" border=\"0\" title=\"Editar\"/></a> ");
		printf("<a href=\"#\" onclick=\"EliminarBanner(".$oBanner->getId() .",".$usuario.")\"><img src=\"images/false.png\" border=\"0\" alt=\"Eliminar banner\" title=\"Eliminar banner\"/></a></form></td>");
		printf("</tr>");
	}
	
	printf("</table>");
}
?>
