<?php    

require_once(__DIR__ . "/../../includes/config.inc");


/* Library settings */ 
 define("CLASS_PATH", __DIR__ . "/class"); 
 define("FONT_PATH", __DIR__ . "/fonts"); 

 /* pChart library inclusions */ 
 include(CLASS_PATH."/pData.class.php"); 
 include(CLASS_PATH."/pDraw.class.php"); 
 include(CLASS_PATH."/pImage.class.php"); 

 /* Create and populate the pData object */ 
 $MyData = new pData();   
 

/* Connect to the MySQL database */
$db = mysqli_connect($host, $user, $pass, $db);
if (!$db) {
	die("Connection failed: " . mysqli_connect_error());
}

$arrMeses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dic");

/* Build the query that will returns the data to graph */
$Requete = "select * from(
			select count(1) as clicks,  month(fecha) as mes, year(fecha) as anyo from n4_Adsrv_estadisticas
			where bannerID = 1
			group by month(fecha), year(fecha)
			order by year(fecha) desc, month(fecha) Desc
			limit 12
			) x
			order by 3 asc, 2 asc";
$Result  = mysqli_query($db, $Requete);
while($row = mysqli_fetch_array($Result))
 {
	$clicks = $row["clicks"];
	$MyData->addPoints(array(2,2,2),"Meses"); 
	$meses = $arrMeses[$row["mes"]]."/".str_replace("20","",$row["anyo"]);
	$MyData->addPoints(array(2,2,2),"Labels"); 
 }

 
 $MyData->setAxisName(0,"N� Clicks"); 
 
 $MyData->setSerieDescription("Labels","Meses"); 
 $MyData->setAbscissa("Labels"); 

 

 /* Create the pChart object */ 
 $myPicture = new pImage(520,130,$MyData); 

 /* Retrieve the image map */ 
 if (isset($_GET["ImageMap"]) || isset($_POST["ImageMap"])) 
  $myPicture->dumpImageMap("ImageMapLineChart",IMAGE_MAP_STORAGE_FILE,"LineChart","tmp"); 

 /* Set the image map name */ 
 $myPicture->initialiseImageMap("ImageMapLineChart",IMAGE_MAP_STORAGE_FILE,"LineChart","tmp"); 

 /* Turn on Antialiasing */ 
 $myPicture->Antialias = TRUE; 


$Settings = array("StartR"=>153, "StartG"=>153, "StartB"=>153, "EndR"=>0, "EndG"=>0, "EndB"=>0, "Alpha"=>80);
$myPicture->drawGradientArea(0,0,520,130,DIRECTION_VERTICAL,$Settings);
 
 /* Add a border to the picture */ 
 $myPicture->drawRectangle(0,0,519,129,array("R"=>0,"G"=>0,"B"=>0)); 



  
 /* Write the chart title */  
 $myPicture->setFontProperties(array("R"=>255,"G"=>255,"B"=>255,"FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>15)); 
// $myPicture->drawText(150,35,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

 /* Set the default font */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6)); 

 /* Define the chart area */ 
 $myPicture->setGraphArea(30,30,510,100); 

 /* Draw the scale */ 
 //$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_START0); 
 $scaleSettings = array("Pos"=>SCALE_POS_LEFTRIGHT
, "Mode"=>SCALE_MODE_START0
, "LabelingMethod"=>LABELING_DIFFERENT
, "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>50, "TickR"=>255, "TickG"=>255, "TickB"=>255, "TickAlpha"=>50, "LabelRotation"=>0,
 "DrawXLines"=>1, "DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);
 $myPicture->drawScale($scaleSettings); 

 
 /* Draw the line chart */ 
 $Settings = array("RecordImageMap"=>TRUE); 
 $myPicture->drawLineChart($Settings); 
 $myPicture->drawPlotChart(array("PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>20,"DisplayValues"=>1,"DisplayColor"=>DISPLAY_AUTO,"FontSize"=>15 )); 
 $Config = array( "BreakVoid"=>10, "BreakR"=>0, "BreakG"=>0, "BreakB"=>0, "R"=>255,"G"=>255,"B"=>255);
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>10));

$myPicture->drawLineChart($Config);
 /* Write the chart legend */ 
 $myPicture->drawLegend(470,10,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 


 
 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("tmp/LineChart.png");
?>