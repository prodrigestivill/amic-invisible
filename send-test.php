<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";
$mailfile = isset($argv[2])?$argv[2]:"send-conf.inc.php";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");
$times = fillRelations($arr, $total);
if ($times<0)
	die("Failed to find relations".PHP_EOL);

echo "HELO server.example.org\r\n";
require($mailfile);
foreach ($arr as &$persons){
	foreach ($persons as &$p){
		echo "MAIL FROM: $email_from\r\n";
		foreach($p["emails"] as $e)
			echo "RCPT TO:<$e>\r\n";
		echo "DATA\r\nFrom: $email_from\r\nTo: ";
		$c="";
		foreach($p["emails"] as $e){
			echo "$c\"".$p["name"]."\" <$e>";
			$c=",";
		}
		echo "\r\nSubject: $email_subject\r\n\r\n";
		echo getBody($email_body, $p);
		echo "\r\n.\r\n";
	}
}
echo "QUIT\r\n";
echo "Relation found in $times times.".PHP_EOL;
?>
