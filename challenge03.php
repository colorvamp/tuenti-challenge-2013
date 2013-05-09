#!/usr/bin/php
<?php
	/* Challenge 3 - Lost in Lost
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);
	//*/

	while($i){
		$script = trim(array_shift($i));
		$script = substr($script,1);
		$events = preg_split('/[.<>]/',$script);
		$events = array_unique(array_diff($events,array('')));
		foreach($events as $k=>$evt){$script = str_replace($evt,$k,$script);}

		/* Trick or treat */
		$r = preg_match('/>(?<init>[0-9]+)(\.[0-9]+\.[0-9\.]+)<(?<end>[0-9]+)/',$script,$m);
		if($r && $m['init'] == $m['end']){echo 'valid'.PHP_EOL;continue;}

		/* INI-remove redundant hierarchy 
		 * if the hierarchy flow this way "a.b<a" or "a>b<a" a is already before b, so we remove it */
		$r = preg_match_all('/[\.<>]{1}(?<init>[0-9]+)[>\.]{1}(?<middle>[0-9]+)<(?<end>[0-9]+)/',$script,$m);
		foreach($m[0] as $k=>$v){if(($pos = strpos($script,$v)) !== false){$script = substr_replace($script,substr($v,0,-strlen($m['end'][$k])-1),$pos,strlen($v));}}
		/* END-remove redundant hierarchy */

		$script = preg_replace('/([0-9]+)<([0-9]+)([0-9\.]{2,})/','$2>$1$3',$script);

		/* INI-Detect chronological incoherences */
		$parts = explode('>',$script);
		$parts = array_map(function($n){return explode('.',$n);},$parts);
		$isInvalid = false;
		foreach($parts as $k=>$v){
			$c = current($v);while(next($v)){$d = current($v);if($c == $d){$isInvalid = true;break;}$c = $d;}
			if($isInvalid){break;}
			if(!isset($parts[$k-1])){continue;}
			$args = call_user_func_array('array_merge',array_slice($parts,0,$k));
			$u = array_intersect($parts[$k],$args);
			if($u){$isInvalid = true;break;}
		}
		if($isInvalid){echo 'invalid'.PHP_EOL;continue;}
		/* END-Detect chronological incoherences */

		$script = preg_replace('/([0-9]+)>([0-9]+)/','$1.$2',$script);
		/* Tree */
		$stream = array();
		$r = preg_match_all('/([0-9\.]{3,})/',$script,$m);
		foreach($m[0] as $k=>$v){
			$v = explode('.',$v);
			foreach($v as $u=>$num){
				$curr = $v[$u];if(isset($v[$u-1]) && $curr == $v[$u-1]){continue;}
				//echo $curr."\n";
				$stream[] = $events[$curr];
			}
		}
		echo implode(',',$stream).PHP_EOL;
//		print_r($stream);exit;
	}
?>
