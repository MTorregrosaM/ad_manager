<?php
require_once(__DIR__ . "/../../includes/config.inc");

define("CLASS_PATH", __DIR__ . "/class");
define("FONT_PATH", __DIR__ . "/fonts");

include(CLASS_PATH . "/pData.class.php");
include(CLASS_PATH . "/pDraw.class.php");
include(CLASS_PATH . "/pImage.class.php");

$dbConnection = mysqli_connect($host, $user, $pass, $db);
if (!$dbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

$data = new pData();
$query = "SELECT DATE(fecha) AS dia, COUNT(*) AS clicks
          FROM n4_adsrv_estadisticas
          WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 13 DAY)
          GROUP BY DATE(fecha)
          ORDER BY dia ASC";
$result = mysqli_query($dbConnection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($dbConnection));
}

while ($row = mysqli_fetch_assoc($result)) {
    $data->addPoints(array((int) $row["clicks"]), "Clicks");
    $data->addPoints(array(date("d/m", strtotime($row["dia"]))), "Labels");
}

$data->setSerieDescription("Labels", "Dias");
$data->setAbscissa("Labels");
$picture = new pImage(520, 130, $data);
$picture->setFontProperties(array("FontName" => FONT_PATH . "/pf_arma_five.ttf", "FontSize" => 6));
$picture->setGraphArea(30, 30, 510, 100);
$picture->drawGradientArea(0, 0, 520, 130, DIRECTION_VERTICAL, array(
    "StartR" => 153, "StartG" => 153, "StartB" => 153,
    "EndR" => 0, "EndG" => 0, "EndB" => 0, "Alpha" => 80
));
$picture->drawRectangle(0, 0, 519, 129, array("R" => 0, "G" => 0, "B" => 0));
$picture->drawScale(array(
    "Pos" => SCALE_POS_LEFTRIGHT,
    "Mode" => SCALE_MODE_START0,
    "GridR" => 255, "GridG" => 255, "GridB" => 255, "GridAlpha" => 50,
    "TickR" => 255, "TickG" => 255, "TickB" => 255, "TickAlpha" => 50,
    "DrawXLines" => 1, "DrawYLines" => ALL
));
$picture->drawLineChart(array("RecordImageMap" => true));
$picture->drawPlotChart(array("PlotBorder" => true, "BorderSize" => 1, "DisplayValues" => 1));
$picture->autoOutput("tmp/DayChart.png");
?>
