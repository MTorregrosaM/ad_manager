<?php 
	
	$pagina = str_replace(".php","",substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'],"admin/")+9, strlen($_SERVER['REQUEST_URI'])));
	
	switch ($pagina){
		case "banners":
			$banners = "class=\"menu-activo\"";
			break;
		case "estadisticas":
			$estads = "class=\"menu-activo\"";
			break;
		case "cobros":
			$cobros = "class=\"menu-activo\"";
			break;
		case "perfil":
			$perfil = "class=\"menu-activo\"";
			break;
		case "contacto":
			$contacto = "class=\"menu-activo\"";
			break;
		case "desconectar":
			break;
	}
	
?>

<div id="menu">
	<ul id="menu-superior">
		<li><a href="n4_banners.php"  <?php echo $banners;?>><?php echo $menu_banners;?></a></li>
		<li><a href="n4_estadisticas.php" <?php echo $estads;?>><?php echo $menu_stadis;?></a></li>
		<?php if (USUARIO != -999){?>
			<li><a href="n4_cobros.php" <?php echo $cobros;?>>Abonos</a></li>
			<li><a href="n4_perfil.php" <?php echo $perfil;?>><?php echo $menu_perfil;?></a></li>
			<li><a href="n4_contacto.php" <?php echo $contacto;?>><?php echo $menu_contacto;?></a></li>
		<?php }?>
		<li><a href="n4_desconectar.php"><?php echo $menu_desconectar;?></a></li>
	</ul>
</div>