<?php
$MAX_RELATIONS_TRIES=1000;

function fillRelations(&$arr, $total){
	global $MAX_RELATIONS_TRIES;
	$times=0;
	do{
		$times++;
		//Reset all data
		foreach ($arr as &$persons){
			foreach ($persons as &$p){
				unset($p["from"]);
				unset($p["to"]);
			}
		}
		//Try a combination
		$t = $total;
		foreach (array_keys($arr) as $gid){
			$avaliable = array();
			foreach ($arr as $kgid => &$persons){
				if ($kgid == $gid)
					continue;
				foreach ($persons as &$p2){
					if (array_key_exists("from", $p2))
						continue;
					$avaliable[]=&$p2;
				}
			}
			foreach ($arr[$gid] as &$p){
				if (count($avaliable)>0){
					$pid = rand(0, count($avaliable)-1);
					$pdst = &$avaliable[$pid];
					$p["to"] = &$pdst;
					$pdst["from"] = &$p;
					$t--;
					unset($avaliable[$pid]);
					$avaliable=array_values($avaliable); //reset index
				}
			}
		}
	}while($t!=0 && $times<$MAX_RELATIONS_TRIES);
return $times<$MAX_RELATIONS_TRIES?$times:-1;
}
?>
