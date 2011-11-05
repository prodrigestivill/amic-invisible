<?php
function import_data($filename, &$ret){
	$total = 0;
	$group = 0;
	$f = fopen ($filename, "r");
	while ($line= fgets ($f)) {
		if (!$line===FALSE){
			$tline=trim($line);
			if (substr($tline,0,1)=='#')
				continue;
			if (strlen($tline)>0){
				$arr = explode("\t",$tline, 3);
				if (strlen($arr[0])<1){
					$group++;
					continue;
				}
				$emails = explode(',',$arr[2]);
				foreach ($emails as &$e)
					$e = trim($e);
				$p = array("name"=>$arr[0], "comments"=>$arr[1], "emails"=>$emails);
				$ret[$group][] = $p;
				$total++;
			}else{
				$group++;
				continue;
			}
		}
	}
	fclose ($f);
	return $total;
}

function getBody($filename, &$from){
	$patterns = array();
	$patterns[] = "/{name}/";
	$replacements[] = $from["name"];
	$patterns[] = "/{comments}/";
	$replacements[] = $from["comments"];
	$patterns[] = "/{email}/";
	$replacements[] = implode(",",$from["emails"]);
	$patterns[] = "/{to-full}/";
	if (strlen($from["comments"])>0)
		$replacements[] = $from["name"]." (".$from["comments"].")";
	else
		$replacements[] = $from["name"];

	$patterns[] = "/{to-name}/";
	$replacements[] = $from["to"]["name"];
	$patterns[] = "/{to-comments}/";
	$replacements[] = $from["to"]["comments"];
	$patterns[] = "/{to-email}/";
	$replacements[] = implode(",",$from["to"]["emails"]);
	$patterns[] = "/{to-full}/";
	if (strlen($from["to"]["comments"])>0)
		$replacements[] = $from["to"]["name"]." (".$from["to"]["comments"].")";
	else
		$replacements[] = $from["to"]["name"];

	$patterns[] = "/{from-name}/";
	$replacements[] = $from["from"]["name"];
	$patterns[] = "/{from-comments}/";
	$replacements[] = $from["from"]["comments"];
	$patterns[] = "/{from-email}/";
	$replacements[] = implode(",",$from["from"]["emails"]);
	$patterns[] = "/{from-full}/";
	if (strlen($from["from"]["comments"])>0)
		$replacements[] = $from["from"]["name"]." (".$from["from"]["comments"].")";
	else
		$replacements[] = $from["from"]["name"];

	return preg_replace($patterns, $replacements, file_get_contents($filename));
}
?>
