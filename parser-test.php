<?php
$listfile = isset($argv[1])?$argv[1]:"list.txt";

require("parser.inc.php");

$ret = array();
$total = import_data($listfile, $ret);
print_r($ret);
echo "Total: $total".PHP_EOL;
?>
