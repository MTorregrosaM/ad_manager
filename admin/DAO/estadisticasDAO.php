<?php 
require_once(__DIR__ . "/../../includes/conexion.inc");
// recuperamos los banners del usuario dado
function getResumenClicks($usuario, $tipo, $fechaIni = null, $fechaFin = null){
	global $connexion;
	try{
		
		$arrClicks = array("act" => 0, "ant" => 0);
		$where = "";
		if ($usuario <> -999)
			$where = " AND est.empresaID =  ".$usuario; 
		// puede ser D diario, M mensual � T total
		switch ($tipo){
			case "D":
				
				$query = "SELECT count(1) as clicks
							FROM n4_adsrv_estadisticas est
							WHERE date_format(fecha,'%Y-%m-%d') = '".date('Y-m-d')."' ".$where."
						  UNION
						  SELECT count(1) as clicks 
							FROM n4_adsrv_estadisticas est
							WHERE date_format(fecha,'%Y-%m-%d') = '".date('Y-m-d', time()-(24*60*60))."' ".$where;
				
				$rsStats = mysqli_query($connexion, $query);
				$i = 0;
				while($fila = mysqli_fetch_array($rsStats)) {
						
					if ($i ==0){
						$arrClicks['act'] = $fila['clicks'];
						$i++;
					}else{
						$arrClicks['ant'] = $fila['clicks'];
					}
				}
				break;
			case "M":
				$diasRestar = date("t",date("m"));
				$diasRestar2meses =  date("t",date(strtotime("-2 months") ));
				$query = "SELECT count(1) as clicks
											FROM n4_adsrv_estadisticas  est
											WHERE date_format(fecha,'%Y-%m-%d') <= '".date('Y-m-d')."' 
											AND date_format(fecha,'%Y-%m-%d') >= '".date("Y-m-")."01' ".$where."
										  UNION
										  SELECT count(1) as clicks 
											FROM n4_adsrv_estadisticas est
											WHERE date_format(fecha,'%Y-%m-%d') <= '".date("Y-m-d",strtotime("last months"))."'
											AND date_format(fecha,'%Y-%m-%d') >= '".date("Y-m-",strtotime("-1 months"))."01' ".$where;
				
				$rsStats = mysqli_query($connexion, $query);
				$i = 0;
				while($fila = mysqli_fetch_array($rsStats)) {
				
					if ($i ==0){
						$arrClicks['act'] = $fila['clicks'];
						$i++;
					}else{
						$arrClicks['ant'] = $fila['clicks'];
					}
				}
				break;
			case "T":
				$query = "SELECT count(1) as clicks
							FROM n4_adsrv_estadisticas  est
							WHERE 1=1 ".$where."
						  UNION
						  SELECT date_format(min(fecha),'%d-%m-%Y') as clicks
						  	FROM n4_adsrv_estadisticas  est
							WHERE 1=1 ".$where;
					
				$rsStats = mysqli_query($connexion, $query);
				$i = 0;
				while($fila = mysqli_fetch_array($rsStats)) {
				
					if ($i ==0){
						$arrClicks['act'] = $fila['clicks'];
						$i++;
					}else{
						$arrClicks['ant'] = $fila['clicks'];
					}
				}
				break;
			case "F":
				
					$query = "SELECT count(1) as clicks
											FROM  n4_adsrv_estadisticas est
											LEFT OUTER JOIN n4_adsrv_empresas emp ON est.empresaID = emp.id 
											JOIN n4_adsrv_banners ban ON est.bannerID = ban.id AND ban.empresaID = est.empresaID
											JOIN phpbb_forums foro ON foro.forum_id = est.foroID
											WHERE 1=1 
											AND fecha >= '".$fechaIni."' and fecha <= date_add('".$fechaFin."', INTERVAL 1 DAY)
											 ".$where;
					
					$rsStats = mysqli_query($connexion, $query);
					while($fila = mysqli_fetch_array($rsStats)) {
						$clicks = $fila['clicks'];
						return $clicks;
					}
					break;
		}
			
		return $arrClicks;
			
	}catch (Exception $ex){
		echo "Error: estadisticasDAO.getResumenClicks";
		return null;
	}

}
?>