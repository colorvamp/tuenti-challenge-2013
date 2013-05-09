#!/usr/bin/php
<?php
	/* Challenge 13 - Sparse randomness
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);

	$t = microtime(1);
	$o = 0;while($i){
		list($nums,$cases) = explode(' ',trim(array_shift($i)));
		$randomNumbers = explode(' ',trim(array_shift($i)));
		$o++;
		echo 'Test case #',$o,PHP_EOL;
		while($cases--){
			list($a,$b) = explode(' ',trim(array_shift($i)));
			$a = intval($a);
			$b = intval($b)-$a;
			$tmp = $randomNumbers;
			$tmp = array_splice($tmp,$a-1,$b+1);
			$repeats = array();
			foreach($tmp as $num){
				if(!isset($repeats[$num])){$repeats[$num] = 1;}else{$repeats[$num] += 1;}
			}
			rsort($repeats);
			echo $repeats[0],PHP_EOL;
		}
	}
	//echo (microtime(1)-$t);
exit;
	/* Another solution, reading espaces secuentially instead of spliting the numbers into an array,
	 * Its slower but less memory hungry, finally I executed this challenge on an 8GB
	 * ram laptop and discarted this first solution */
	$i = file('php://stdin');
	array_shift($i);


	$t = microtime(1);
	$o = 0;while($i){
		list($nums,$cases) = explode(' ',trim(array_shift($i)));
		$randomNumbers = ' '.trim(array_shift($i)).' ';
		$o++;
		echo 'Test case #',$o,PHP_EOL;
		while($cases--){
			list($a,$b) = explode(' ',trim(array_shift($i)));
			$a = intval($a);
			$b = intval($b)-$a;
			$init = 0;while($a--){$init = strpos($randomNumbers,' ',$init)+1;}
			$randomNumbersCopy = substr($randomNumbers,$init);
			$repeats = array();
			$b -= $a;
			$end = $init;while($b--){
				$e = strpos($randomNumbersCopy,' ');
				$num = substr($randomNumbersCopy,0,$e);
				if(!isset($repeats[$num])){$repeats[$num] = 1;}else{$repeats[$num]++;}
				$end = $e+1;
				$randomNumbersCopy = substr($randomNumbersCopy,$end);
			}
			rsort($repeats);
			echo $repeats[0],PHP_EOL;
		}
	}
	echo (microtime(1)-$t);
?>
