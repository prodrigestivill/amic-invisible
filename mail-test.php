<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";
$bodyfile = isset($argv[2])?$argv[2]:"body.txt";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");

$times = fillRelations($arr, $total);

foreach ($arr as &$persons){
	foreach ($persons as &$p){
		foreach($p["emails"] as $e)
			echo "RCPT TO:<$e>\r\n";
		echo "DATA\r\nTo: ";
		$c="";
		foreach($p["emails"] as $e){
			echo "$c\"".$p["name"]."\" <$e>";
			$c=",";
		}
		echo "\r\n";
		echo getBody($bodyfile, $p);
		echo "\r\n.\r\n";
	}
}
echo "Done $times times.\n";
?>
