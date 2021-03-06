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
echo "Relation found in $times times.".PHP_EOL;

echo "Do you really want to send this my mail? Type 'yes' to continue: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
fclose($handle);
if(trim($line) != 'yes'){
    echo "ABORTING!".PHP_EOL;
    exit(1);
}
echo PHP_EOL."Preparing to send...".PHP_EOL;
require($mailfile);
require_once "Mail.php"; //Using PEAR-Mail
$smtp = Mail::factory('smtp', $smtp_configuration);

foreach ($arr as &$persons){
	foreach ($persons as &$p){
		$to = array();
		foreach($p["emails"] as $e){
			$to[]="\"".$p["name"]."\" <$e>";
		}
		$headers = array(	'From' => $email_from,
					'To' => $to,
					'Subject' => $email_subject);
		$body = getBody($email_body, $p);
		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail)) {
			echo("Error while sending to ".$p["name"].": ".$mail->getMessage().PHP_EOL);
			echo("  -> Pending to send this association: ".$p["name"]." -> ".$p["to"]["name"].PHP_EOL);
		} else {
			echo("Message successfully sent to ".$p["name"].PHP_EOL);
		}
	}
}

?>
