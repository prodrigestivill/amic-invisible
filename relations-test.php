<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");

$times = fillRelations($arr, $total);
if ($times<0)
	die("Failed to find relations");

foreach ($arr as &$persons){
	foreach ($persons as &$p){
		echo $p["name"]." -> ".$p["to"]["name"]." <- ".$p["to"]["from"]["name"]."\n";
	}
}
echo "Done $times times.\n";
?>
