#!/usr/bin/php
<?php
	/* Challenge 9 - Defenders of the Galaxy
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);

	while($i){
		$l = array_shift($i);
		list($w,$h,$soldierCost,$cremaCost,$gold) = explode(' ',$l);
		$cremaCost = intval($cremaCost);
		$numSoldiers = floor($gold/$soldierCost);
		if($numSoldiers >= $w){echo '-1'.PHP_EOL;continue;}
		$maxSeconds = resolveGame($w,$h,$numSoldiers,$gold,$cremaCost,$soldierCost);
		while($numSoldiers--){
			$seconds = resolveGame($w,$h,$numSoldiers,$gold,$cremaCost,$soldierCost);
			if($seconds > $maxSeconds){$maxSeconds = $seconds;}
		}
		echo $maxSeconds.PHP_EOL;
	};

	function resolveGame($w,$h,$numSoldiers,$gold,$cremaCost,$soldierCost){
		$gold -= $numSoldiers*$soldierCost;
		$limit = $w*$h;
		$zorg = 0;
		$seconds = -1;
		while(1){
			$seconds++;
			$zorg += $w;
			if($zorg > $limit){break;}
			$zorg -= $numSoldiers;
			if($zorg > ($limit-$w) && $gold >= $cremaCost){
				//echo 'usado crematorium en el segundo ('.$seconds.') zorgs ('.$zorg.') limit ('.$limit.')'.PHP_EOL;
				$gold -= $cremaCost;
				$zorg = 0;
				continue;
			}
		}

		return $seconds;
	}
?>
