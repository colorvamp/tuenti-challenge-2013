#!/usr/bin/php
<?php
	/* Challenge 2 - Did you mean...?
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);
	$dict = substr(array_shift($i),0,-1);
	array_shift($i);// #Suggestion numbers
	array_shift($i);
	array_shift($i);// #Find the suggestions
	$words = array();
	while($word = array_shift($i)){$words[] = substr($word,0,-1);}
	//*/

	//$dict = 'smallDictionary';
	//$words = array('huhedskiqpugqbkrcpi','iyqpyaspqrexttslx','kiqpugqbkrcpihuheds','natioladoxcrubrntrr','oogrenkpals');
	$wordsLen = $wordsLen_byLen = $wordArrays_sorted = $wordArrays = $candidates = array();
	foreach($words as $k=>$word){
		$wordsLen[$k] = strlen($word);
		$wordsLen_byLen[$wordsLen[$k]][] = $k;
		$wordArrays[$k] = str_split($word);
		$tmp = $wordArrays[$k];
		sort($tmp);
		$wordArrays_sorted[$k] = implode('',$tmp);
	}

	/* Do this or pay 3 and use a Tutor: http://magiccards.info/po/en/9.html */
	$chunkSize = 6144;
	$src = fopen($dict,'r');
	while(!feof($src)){
		$possible = fgets($src,$chunkSize);
		$possible = substr($possible,0,-1);
		$possibleLen = strlen($possible);
		$possibleArray = str_split($possible);
		/* For fast discard */
		if(!isset($wordsLen_byLen[$possibleLen])){continue;}
		foreach($wordsLen_byLen[$possibleLen] as $k){
			/* cant be the same word */
			if($possible == $words[$k]){continue;}
			$tmp = $possibleArray;sort($tmp);$tmp = implode('',$tmp);
			if($tmp == $wordArrays_sorted[$k]){$candidates[$k][] = $possible;continue;}
		}
	}
	fclose($src);

	foreach($words as $k=>$word){
		sort($candidates[$k]);
		echo $word.' -> '.implode(' ',$candidates[$k]).PHP_EOL;
	}
?>
