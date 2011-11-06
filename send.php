<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";
$bodyfile = isset($argv[2])?$argv[2]:"body.txt";

require("parser.inc.php");
$arr = array();
$total = import_data($listfile, $arr);

require("relations.inc.php");

$times = fillRelations($arr, $total);
if ($times<0)
	die("Failed to find relations");
echo "Done $times times.\n";

echo "Do you really want to send this my mail? Type 'yes' to continue: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
fclose($handle);
if(trim($line) != 'yes'){
    echo "ABORTING!\n";
    exit(1);
}
echo "\nPreparing to send...\n";
require("send-conf.inc.php");
require_once "Mail.php"; //Using PEAR-Mail
$smtp = Mail::factory('smtp',$smtp_configuration);

foreach ($arr as &$persons){
	foreach ($persons as &$p){
		$to = array();
		foreach($p["emails"] as $e){
			$to[]="\"".$p["name"]."\" <$e>";
		}
		$headers = array(	'From' => $email_from,
					'To' => $to,
					'Subject' => $email_subject);
		$body = getBody($bodyfile, $p);
		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail)) {
			echo("Error while sending to ".$p["name"].": ".$mail->getMessage()."\n");
		} else {
			echo("Message successfully sent to ".$p["name"]."\n");
		}
	}
}

?>
