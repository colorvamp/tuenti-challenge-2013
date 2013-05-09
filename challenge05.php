#!/usr/bin/php
<?php
	/* Challenge 5 - Dungeon Quest
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$i = file('php://stdin');
	array_shift($i);

	while($i){
		$gridSize = explode(',',array_shift($i));/* Grid size */
		$knightPos = array_shift($i);
		$seconds = intval(array_shift($i));
		array_shift($i);/* Gems numbers, not needed, I found it in other way */
		$gemsString = array_shift($i);

		$GLOBALS['grid'] = array();
		$gx = intval($gridSize[0]);$gy = intval($gridSize[1]);while($gx--){$GLOBALS['grid'][$gx] = array_fill(0,$gy,0);}
		$GLOBALS['grid'] = array_reverse($GLOBALS['grid']);

		$gemsByID = array();
		$tmp = explode('#',$gemsString);foreach($tmp as $k=>$gem){
			list($x,$y,$v) = explode(',',$gem);$k++;
			$GLOBALS['grid'][$x][$y] = $v;
			$gemsByID[$k] = array('k'=>$k,'x'=>$x,'y'=>$y,'v'=>$v);
		}

		$GLOBALS['maxPoints'] = array();
		/* The knight position */
		list($knightX,$knigthY) = explode(',',$knightPos);
		$knightX = intval($knightX);$knigthY = intval($knigthY);

		$places[$knightX][$knightX] = '';
		move($knightX,$knightX,$places,$seconds,0);
		rsort($GLOBALS['maxPoints']);
		$top = array_shift($GLOBALS['maxPoints']);
		echo $top.PHP_EOL;
	}

	/* http://store.steampowered.com/app/35480/?l=spanish */
	function move($x,$y,$places,$seconds,$threadPoints){
		if(!$seconds){$GLOBALS['maxPoints'][] = $threadPoints;return;}
		$seconds--;

		if(isset($GLOBALS['grid'][$x-1][$y]) && !isset($places[$x-1][$y])){
			$p = $threadPoints;if($GLOBALS['grid'][$x-1][$y]){$p += $GLOBALS['grid'][$x-1][$y];}
			$v = $places;$v[($x-1)][$y] = '';
			move(($x-1),$y,$v,$seconds,$p);
		}
		if(isset($GLOBALS['grid'][$x][$y+1]) && !isset($places[$x][$y+1])){
			$p = $threadPoints;if($GLOBALS['grid'][$x][$y+1]){$p += $GLOBALS['grid'][$x][$y+1];}
			$v = $places;$v[$x][($y+1)] = '';
			move($x,($y+1),$v,$seconds,$p);
		}
		if(isset($GLOBALS['grid'][$x+1][$y]) && !isset($places[$x+1][$y])){
			$p = $threadPoints;if($GLOBALS['grid'][$x+1][$y]){$p += $GLOBALS['grid'][$x+1][$y];}
			$v = $places;$v[($x+1)][$y] = '';
			move(($x+1),$y,$v,$seconds,$p);
		}
		if(isset($GLOBALS['grid'][$x][$y-1]) && !isset($places[$x][$y-1])){
			$p = $threadPoints;if($GLOBALS['grid'][$x][$y-1]){$p += $GLOBALS['grid'][$x][$y-1];}
			$v = $places;$v[$x][($y-1)] = '';
			move($x,($y-1),$v,$seconds,$p);
		}
	}
?>
