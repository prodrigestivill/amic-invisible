<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");
$times = fillRelations($arr, $total);
if ($times<0)
	die("Failed to find relations".PHP_EOL);

$first = null;
foreach ($arr as &$persons){
	foreach ($persons as &$p){
		$first = $p;
		break;
	}
	break;
}
if ($first!=null){
	$cur = &$first;
	do{
		echo $cur["name"]." -> ";
		$cur = &$cur["to"];
	}while($first != $cur);
	echo "...".PHP_EOL;
}
echo "Done $times times.".PHP_EOL;
?>
