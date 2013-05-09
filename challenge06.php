#!/usr/bin/php
<?php
	/* Challenge 6 - Ice Cave
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);
	$meSymbol = chr(88);
	$GLOBALS['exSymbol'] = chr(79);

	while(($input = array_shift($i))){
		$input = explode(' ',$input);
		list($x,$y,$GLOBALS['speed'],$GLOBALS['stall']) = $input;
		$GLOBALS['speed'] = intval($GLOBALS['speed']);
		$GLOBALS['stall'] = intval($GLOBALS['stall']);
		$GLOBALS['dungeon'] = array();
		$GLOBALS['measures'] = array();
		$meX = $meY = $exY = $exX = false;
		$k = -1;while($k < $y-1){
			$k++;
			$l = str_replace(chr(194).chr(183),' ',array_shift($i));
			if(($pos = strpos($l,$meSymbol)) !== false){$meX = $pos;$meY = $k;}
			if(($pos = strpos($l,$GLOBALS['exSymbol'])) !== false){$exX = $pos;$exY = $k;}
			$l = str_split(substr($l,0,-1));
			foreach($l as $j=>$m){$GLOBALS['dungeon'][$j][$k] = $m;}
			
		}

		//$h = 1 up, 2 right, 3 down, 4 left
		if($GLOBALS['dungeon'][$meX][$meY-1] != '#'){move($meX,$meY,1,array(),0,1);}
		if($GLOBALS['dungeon'][$meX][$meY+1] != '#'){move($meX,$meY,3,array(),0,1);}
		if($GLOBALS['dungeon'][$meX-1][$meY] != '#'){move($meX,$meY,4,array(),0,1);}
		if($GLOBALS['dungeon'][$meX+1][$meY] != '#'){move($meX,$meY,2,array(),0,1);}
		sort($GLOBALS['measures']);
		echo array_shift($GLOBALS['measures']).PHP_EOL;
		continue;	
	}

	function move($x,$y,$h,$places,$steps,$stalls,$movements = array()){
		if($h == 2){/* right */while(isset($GLOBALS['dungeon'][$x+1][$y]) && $GLOBALS['dungeon'][$x+1][$y] != '#'){$steps++;$x++;}}
		if($h == 4){/* left */while(isset($GLOBALS['dungeon'][$x-1][$y]) && $GLOBALS['dungeon'][$x-1][$y] != '#'){$steps++;$x--;}}
		if($h == 1){/* up */while(isset($GLOBALS['dungeon'][$x][$y-1]) && $GLOBALS['dungeon'][$x][$y-1] != '#'){$steps++;$y--;}}
		if($h == 3){/* down */while(isset($GLOBALS['dungeon'][$x][$y+1]) && $GLOBALS['dungeon'][$x][$y+1] != '#'){$steps++;$y++;}}
		if(isset($places[$x][$y])){return;}$places[$x][$y] = 1;
		/* The exit! http://t0.gstatic.com/images?q=tbn:ANd9GcQCr-z16uYy5wCbtYCe5EQPNAXkWOPs_gKK1PMz_Yaixc2XfoU5 */
		if($GLOBALS['dungeon'][$x][$y] == $GLOBALS['exSymbol']){$GLOBALS['measures'][] = round(($stalls*$GLOBALS['stall'])+($steps/$GLOBALS['speed']));return;}

		$stalls++;
		if(isset($GLOBALS['dungeon'][$x-1][$y]) && $GLOBALS['dungeon'][$x-1][$y] != '#'){$movements[] = 4;move($x,$y,4,$places,$steps,$stalls,$movements);}
		if(isset($GLOBALS['dungeon'][$x+1][$y]) && $GLOBALS['dungeon'][$x+1][$y] != '#'){$movements[] = 4;move($x,$y,2,$places,$steps,$stalls,$movements);}
		if(isset($GLOBALS['dungeon'][$x][$y-1]) && $GLOBALS['dungeon'][$x][$y-1] != '#'){$movements[] = 4;move($x,$y,1,$places,$steps,$stalls,$movements);}
		if(isset($GLOBALS['dungeon'][$x][$y+1]) && $GLOBALS['dungeon'][$x][$y+1] != '#'){$movements[] = 4;move($x,$y,3,$places,$steps,$stalls,$movements);}
	}
?>
