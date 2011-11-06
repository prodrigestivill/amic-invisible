<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");
$times = fillRelations($arr, $total);
if ($times<0)
	die("Failed to find relations".PHP_EOL);

foreach ($arr as &$persons){
	foreach ($persons as &$p){
		echo $p["name"]." -> ".$p["to"]["name"]." <- ".$p["to"]["from"]["name"].PHP_EOL;
	}
}
echo "Done $times times.".PHP_EOL;
?>
