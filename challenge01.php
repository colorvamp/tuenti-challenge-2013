#!/usr/bin/php
<?php
	/* Challenge 1 - Bitcoin to the future
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);//*/

	while($budget = array_shift($i)){
		$chain = trim(array_shift($i));
		$chain = explode(' ',$chain);
		/* We get relative max numbers positions */
		$mins = array();$maxs = array();$count = count($chain);
		for($j = 0;$j<$count;$j++){
			$base = $chain[$j];
			for($l = $j+1;$l<$count;$l++){
				if($chain[$l] <= $base){break;}
				if(!isset($chain[$l+1]) || $chain[$l] > $chain[$l+1]){$mins[] = $base;$maxs[] = $chain[$l];$j = $l;break;}
			}
		}

		/* Even the powerpuff girls would be pride :/ */
		foreach($mins as $pos=>$value){
			$coins = $budget/$mins[$pos];
			$budget = $coins*$maxs[$pos];
		}

		echo $budget.PHP_EOL;
	}
?>
