#!/usr/bin/php
<?php
	/* Challenge 18 - Energy will be infinities
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	//$i = array('5','5','0 1 20','1 2 -20','2 0 1','3 4 20','4 3 -15');
	$i = file('php://stdin');
	array_shift($i);

	$c = 0;while($i){$c++;
//if($c > 3){break;}
		$GLOBALS['isInvalid'] = 'False';
		$numLocations = intval(array_shift($i));
		$numMovements = intval(array_shift($i));
		$GLOBALS['locations'] = $GLOBALS['modifiers'] = array();
		$paths = array();
		while($numMovements--){
			list($orig,$dest,$perc) = explode(' ',trim(array_shift($i)));
			$key = $orig.'_'.$dest;
			if($perc == 0 || isset($GLOBALS['modifiers'][$key])){continue;}
			if($orig == $dest && $perc > 0){$GLOBALS['isInvalid'] = 'True';break;}
			if($orig == $dest && $perc < 0){continue;}
			$paths[$orig] = 1;$GLOBALS['locations'][$orig][] = $dest;
			$GLOBALS['modifiers'][$key] = $perc;
		}
		if($GLOBALS['isInvalid'] == 'True'){echo $GLOBALS['isInvalid'].PHP_EOL;continue;}

		$GLOBALS['testNum'] = $c;
		$paths = array_keys($paths);
		//print_r($paths);
		foreach($paths as $path){move($path,array(),100);}
		//move(3,array(),100);
		echo $GLOBALS['isInvalid'].PHP_EOL;
	}

	function move($next,$places,$currentEnergy){
		if($GLOBALS['isInvalid'] == 'True'){return;}
//echo $currentEnergy.PHP_EOL;
		if(isset($places[$next])){
			$infiniteLoop = false;foreach($places as $plc){if($plc > 1){$infiniteLoop = true;break;}}
			/* If our energy is over 100, is invalid */
			if($infiniteLoop && $currentEnergy > 100){
				$line = $GLOBALS['testNum'].' '.implode(' ',$places).PHP_EOL;
				file_put_contents('failures',$line,FILE_APPEND);
				$GLOBALS['isInvalid'] = 'True';
			}
			if($infiniteLoop){return;}
		}

		if(!isset($places[$next])){$places[$next] = 1;}else{$places[$next]++;}
		/* we have no path to follow */
		if(!isset($GLOBALS['locations'][$next]) || !$GLOBALS['locations'][$next]){return;}
		$childs = $GLOBALS['locations'][$next];
		foreach($childs as $child){
			//if(isset($places[$child]) && $places[$child] > 1){continue;}
			$perc = $GLOBALS['modifiers'][$next.'_'.$child];
			$energy = calcEnergy($currentEnergy,$perc);
			move($child,$places,$energy);
		}
	}

exit;

	
	$currentEnergy = 100;$currentEnergy = calcEnergy($currentEnergy,$modifiers[$nextLocation]);

	$isValid = 'valid';
	$limit = 30;while($limit--){
		/* No next location, for security */
		if(!isset($locations[$nextLocation])){break;}

		$loc = $locations[$nextLocation];
		if(!isset($places[$loc])){$places[$loc] = 1;}else{$places[$loc]++;}
		$currentEnergy = calcEnergy($currentEnergy,$modifiers[$loc]);

		if($places[$loc] == 3){
			$infiniteLoop = true;
			foreach($places as $plc){if($plc < 2){$infiniteLoop = false;break;}}
			if($infiniteLoop){
				/* If our energy is over 100, you is invalid */
				if($currentEnergy > 100){$isValid = 'Invalid';break;}
				/* We gonna search now the last consecutive element */
				ksort($places);$places = array_keys($places);$lastPlace = array_shift($places);
				foreach($places as $plc){if($plc-1 != $lastPlace){break;}$lastPlace = $plc;}
				/* We have the last consecutive place, we must start in the next following one */
				echo 'bucle infinito'.PHP_EOL;
				echo 'ultimo consecutivo -> '.$lastPlace.PHP_EOL;
				/* Searching for the nect following */
				$nextLocation = false;foreach($locations as $sloc=>$dummy){if($sloc <= $lastPlace){continue;}$nextLocation = $sloc;break;}
				if($nextLocation === false){
					echo 'No hay una siguiente localización, salimos'.PHP_EOL;exit;
				}
				echo 'la siguiente loc es -> '.$nextLocation.PHP_EOL;
				/* Reset $places to detect other infinite bucles */
				$places = array();$currentEnergy = 100;
				continue;
			}
		}
		echo $currentEnergy.PHP_EOL;

		$nextLocation = $loc;
	}
	echo $isValid;

	function calcEnergy($currentEnergy,$perc){
		$c = ($currentEnergy/100)*$perc;
		return $currentEnergy+$c;
	}
?>
