#!/usr/bin/php
<?php
	/* Challenge 7 - Boozzle
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);
	$dictWords = explode(PHP_EOL,substr(file_get_contents('challenge07.boozzle.dict.txt'),0,-1));
	$GLOBALS['wordsStrings'] = array();
	foreach($dictWords as $dictWord){$a = str_split($dictWord);$indx = '';foreach($a as $b){$indx .= $b;$GLOBALS['wordsStrings'][$indx] = 1;}}
	$GLOBALS['maxWordLen'] = 15;

	while($i){
		$GLOBALS['wordValues'] = json_decode(str_replace('\'','"',array_shift($i)),1);
		$seconds = intval(array_shift($i));
		$x = intval(array_shift($i));
		$y = intval(array_shift($i));
		$possibleWords = $dictWords;
		$GLOBALS['grid'] = array();
		for($t=0;$t<$y;$t++){
			$l = array_diff(explode(' ',substr(array_shift($i),0,-1)),array(''));
			foreach($l as $k=>$v){$GLOBALS['grid'][$k][$t] = $v;}
		}

		$s = $seconds-1;
		foreach($possibleWords as $k=>$p){if(strlen($p) > $seconds){unset($possibleWords[$k]);}}
		$GLOBALS['possibleWords'] = array_fill_keys($possibleWords,0);

		//$GLOBALS['grid'] = /* x */array(/* y */array('B11','I11'),array('B11','P11'));
		$GLOBALS['xlimit'] = $x-1;
		$GLOBALS['ylimit'] = $y-1;

		$c = 0;foreach($GLOBALS['grid'] as $xAxis=>$tmp){foreach($tmp as $yAxis=>$dummy){move($xAxis,$yAxis,array(),'',0,$seconds);}}
		/* Remove the non-matching words */
		foreach($GLOBALS['possibleWords'] as $k=>$v){if(empty($v)){unset($GLOBALS['possibleWords'][$k]);}}
		/* we calculate the ratio of the points/letter to choose the most interestings first */
		$wordsByRatio = array();/* <- For testing pourposes */
		$pointsByLetter = array();foreach($GLOBALS['possibleWords'] as $w=>$p){$len = strlen($w);$ratio = strval($p/$len);$pointsByLetter[$ratio][$p][] = $len;$wordsByRatio[$ratio][$p][] = $w;}
		krsort($pointsByLetter);

		/* Find x <- here is x */
		$data = $GLOBALS['possibleWords'];
		$weights = array();
		$values = array();
		foreach($data as $k=>$v){$weights[] = strlen($k)+1;$values[] = $v;};

		$m = array();
		$maxPoints = knapSolveFast($weights,$values,sizeof($values)-1,$seconds,$m);
		echo $maxPoints.PHP_EOL;
		continue;
	}

	function move($x,$y,$places,$word,$wordLength,$limit = 0){
		//if(!isset($GLOBALS['grid'][$x][$y])){return;}
		$word .= substr($GLOBALS['grid'][$x][$y],0,1);
		if(!isset($GLOBALS['wordsStrings'][$word])){return;}
		$places[$x][$y] = 1;
		$wordLength++;
		$limit--;
		if(isset($GLOBALS['possibleWords'][$word])){$score = getScore($places);if($score > $GLOBALS['possibleWords'][$word]){$GLOBALS['possibleWords'][$word] = $score;}}
		if($wordLength >= $GLOBALS['maxWordLen']){return;}
		if($limit < 1){return;}

		$xAxis = $x;$yAxis = $y;
		/* LEFT */if($xAxis > 0 && !isset($places[$xAxis-1][$yAxis])){move($xAxis-1,$yAxis,$places,$word,$wordLength,$limit);}
		/* RIGHT */if($xAxis < $GLOBALS['xlimit'] && !isset($places[$xAxis+1][$yAxis])){move($xAxis+1,$yAxis,$places,$word,$wordLength,$limit);}
		/* TOP */if($yAxis > 0 && !isset($places[$xAxis][$yAxis-1])){move($xAxis,$yAxis-1,$places,$word,$wordLength,$limit);}
		/* BOTTOM */if($yAxis < $GLOBALS['ylimit'] && !isset($places[$xAxis][$yAxis+1])){move($xAxis,$yAxis+1,$places,$word,$wordLength,$limit);}
		/* LEFT-TOP */if($yAxis > 0 && $xAxis > 0 && !isset($places[$xAxis-1][$yAxis-1])){move($xAxis-1,$yAxis-1,$places,$word,$wordLength,$limit);}
		/* TOP-RIGHT */if($yAxis > 0 && $xAxis < $GLOBALS['xlimit'] && !isset($places[$xAxis+1][$yAxis-1])){move($xAxis+1,$yAxis-1,$places,$word,$wordLength,$limit);}
		/* LEFT-BOTTOM */if($yAxis < $GLOBALS['ylimit'] && $xAxis > 0 && !isset($places[$xAxis-1][$yAxis+1])){move($xAxis-1,$yAxis+1,$places,$word,$wordLength,$limit);}
		/* BOTTOM-RIGHT */if($yAxis < $GLOBALS['ylimit'] && $xAxis < $GLOBALS['xlimit'] && !isset($places[$xAxis+1][$yAxis+1])){move($xAxis+1,$yAxis+1,$places,$word,$wordLength,$limit);}
	}

	function getScore($places,$debug = false){
		$wordMod = 1;$score = 0;$c = 0;
		foreach($places as $x=>$tmp){
			foreach($tmp as $y=>$dummy){
				$c++;
				list($w,$m,$n) = str_split($GLOBALS['grid'][$x][$y]);
				$v = $GLOBALS['wordValues'][$w];
				if($m == 1){$score += $v*$n;continue;}
				$score += $v;
				if($n > $wordMod){$wordMod = $n;}
			}
		}
		return ($score*$wordMod)+$c;
	}

	function knapSolveFast($w,$v,$i,$aW,&$m){
		if(isset($m[$i][$aW])){return $m[$i][$aW];}
 
		if($i == 0){
			if($w[$i] <= $aW){$m[$i][$aW] = $v[$i];return $v[$i];}
			$m[$i][$aW] = 0;return 0;
		}	
 
		$without_i = knapSolveFast($w,$v,$i-1,$aW,$m);
		if($w[$i] > $aW){$m[$i][$aW] = $without_i;return $without_i;}
		$with_i = $v[$i] + knapSolveFast($w,$v,($i-1),($aW-$w[$i]),$m);
		$res = max($with_i, $without_i); 
		$m[$i][$aW] = $res;
		return $res;	
	}
?>
