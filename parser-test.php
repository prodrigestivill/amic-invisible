<?php
require("parser.inc.php");

$ret = array();
$total = import_data("list.txt", $ret);
print_r($ret);
echo "Total: $total\n";
?>
