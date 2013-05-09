#!/usr/bin/php
<?php
	/* Challenge 11 - Escape from Pixel Island
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 * You will need convert from imagemagick and zbarimg from zxing
	 * - apt-get install imagemagick
	 * - apt-get install zbar-tools
	 */

	$i = file('php://stdin');
	array_shift($i);

	$c = 0;while($i){
		$l = array_shift($i);
		list($test1,$test2) = explode(' ',trim($l));
		/* TESTS de tuenti | pppbwwwwbbbww | pwbwpwwbw */
		/* TESTS propios | pppppwpwbbwbwwbwpwbwbbpbwwwwbwbpwwwwb | pppppbwbwbpbwwwwbwwwpwbwwwbpwwwwb */
		//$test1 = 'ppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppwwppwppbpppppwppwppppppppppppppppppppwpppppwppppbwppwpppppppbwppwwpbpppwppppppppppppppppbppppppppppwpppppppppppppppppppppppppppppppwppppppppwpppppbppppppppppppppppppbpppppwwppwwppppbpppppwwppwwwppwppppbbppwppwpppwpppppppppppppbppppwpppwwwpwwwwpwpppppwwwwbbwwbbwbbwwbbwwwbbwwbwwbbwwbbwwbbwwwbbwwbwwbbbwwbbwwbbwwbbwwbwbwwbwwwbbwbbbbwwbbwbwwbwbwbbwwbbwwwbwwbbwbbwwwbbbbwwbwbbbwwbbwwwbbwbwwbbbwwwbwbbwbbbwwwbwwwwbbwwbwwbwwbwwwwbwwbbbbwwwwwwbwbwwbwwwwwbwwbbwwbbwbbbwwbwwbbwwbwwbbbwwwwbbwbwbwbbbwbwbbwwbbwwbwbwwwbbbwbbwbbwwwbbwwbbwbbwwbbbwwbbwbbwwwbbwbbwwbbwwwbbwwbwwbbwwwbwwbbwbwwbwbbwwbbbwwwbbwbwwbbbwwwwbbwwwwbbwwwwbwbwwwbbwbwwwbbwwbbwwbbwwbbwwbwwwbwwwbbwbbwbbbwwbwbbbbbbwwwbwwbwbwbbbbwwwwbbwbbwwwwwbwwbwbbwwwbbwwbwwwbbwbbbwwwbwbbbwwbwbbwbbbbbwwbwwbwbbwbwwbwwwwbwwwbwwbwwwwbwwbbbwbwwwbwwwbbbwbbwwwbwwbwwwbbwwwbbwwbbwwbbwwbwwwbbwwbbwwbbwbbwwbbwwbbwwwbwwbbwwwwwbwbwbwwbbbwbwwwbwwbwwwwbbbwwwbwwwwbwwbwwwwbwwwbbwbwwwbbwwwbwwwwbwbbbwbwwwwbwwwwbwbwwbbwbwwbbwwwbwbwwwbbbwwwbwbbwwbbwbwwwbbwwbbbwwbbbwwbbwwbwwbbwbwbbwbwwwwbbwbbwwbwbwbbwwwbwwbbwwwbwwbwbbwbbwbwbbwwwbbbww';
		//$test2 = 'ppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppwwppwppbpppppwppwppppppppppppppppppppwpppppwppppbwppwpppppppbwppwwpbpppwppppppppppppppppbppppppppppwpppppppppppppppppppppppppppppppwppppppppwpppppbppppppppppppppppppbpppppwwppwwppppbpppppwwppwwwppwppppbbppwppwpppwpppppppppppppbppppwpppwwwpwwwwpwpppppwwwwbbwwbbwbbwwbbwwwbbwwbwwbbwwbbwwbbwwwbbwwbwwbbbwwbbwwbbwwbbwwbwbwwbwwwbbwbbbbwwbbwbwwbwbwbbwwbbwwwbwwbbwbbwwwbbbbwwbwbbbwwbbwwwbbwbwwbbbwwwbwbbwbbbwwwbwwwwbbwwbwwbwwbwwwwbwwbbbbwwwwwwbwbwwbwwwwwbwwbbwwbbwbbbwwbwwbbwwbwwbbbwwwwbbwbwbwbbbwbwbbwwbbwwbwbwwwbbbwbbwbbwwwbbwwbbwbbwwbbbwwbbwbbwwwbbwbbwwbbwwwbbwwbwwbbwwwbwwbbwbwwbwbbwwbbbwwwbbwbwwbbbwwwwbbwwwwbbwwwwbwbwwwbbwbwwwbbwwbbwwbbwwbbwwbwwwbwwwbbwbbwbbbwwbwbbbbbbwwwbwwbwbwbbbbwwwwbbwbbwwwwwbwwbwbbwwwbbwwbwwwbbwbbbwwwbwbbbwwbwbbwbbbbbwwbwwbwbbwbwwbwwwwbwwwbwwbwwwwbwwbbbwbwwwbwwwbbbwbbwwwbwwbwwwbbwwwbbwwbbwwbbwwbwwwbbwwbbwwbbwbbwwbbwwbbwwwbwwbbwwwwwbwbwbwwbbbwbwwwbwwbwwwwbbbwwwbwwwwbwwbwwwwbwwwbbwbwwwbbwwwbwwwwbwbbbwbwwwwbwwwwbwbwwbbwbwwbbwwwbwbwwwbbbwwwbwbbwwbbwbwwwbbwwbbbwwbbbwwbbwwbwwbbwbwbbwbwwwwbbwbbwwbwbwbbwwwbwwbbwwwbwwbwbbwbbwbwbbwwwbbbww';
		$x = read_y(str_split(substr($test1,1),4));
		$y = read_y(str_split(substr($test2,1),4));
		$x = mergeArrays($x,$y);

		$blob = paintY($x,800);
		file_put_contents('test.svg',$blob);
		shell_exec('convert test.svg test.png');
		unlink('test.svg');
		$r = shell_exec('zbarimg test.png 2>&1');
		$qr = preg_match('/QR-Code:(?<qr>[^\n]+)/',$r,$m);
		echo $m['qr'].PHP_EOL;
	}
exit;
	//p pppp | wpwb | bwbw | wbwp | wbwb |-| bpbw | wbwb |-| wbpw | wwwb
	$GLOBALS['levels'] = array();
	function array2string2($array = array(),$level = 0){
		$str = '';
		foreach($array as $n=>$v){if(is_array($v)){$str .= 'p';continue;}$str .= $v;}
		$GLOBALS['levels'][$level][] = $str;
		$level++;
		foreach($array as $n=>$v){if(is_array($v)){array2string2($v,$level);continue;}}
		if($level == 1){
			$tmp = array_map(function($n){return implode('',$n);},$GLOBALS['levels']);
			$final = implode('',$tmp);
			return $final;
		}
	}

	function read_y($arr,$s = false){
		$cuts = array();
		$subchains = array(array_shift($arr));
		$cuts[] = $subchains;
		while($arr){
			$u = implode('',$subchains);
			$size = substr_count($u,'p');
			$subchains = array_splice($arr,0,$size);
			$cuts[] = $subchains;
		}
		$cuts = array_reverse($cuts);
		$rest = false;foreach($cuts as $curr){
			$u = implode('',$curr);
			$f = array();foreach($curr as $key){
				if(!substr_count($key,'p')){$f[] = str_split($key);continue;}
				$key = str_split($key);
				foreach($key as $o=>$z){if($z == 'p'){$key[$o] = array_shift($rest);}}
				$f[] = $key;
			}
			$rest = $f;
		}
		return array_shift($rest);
	}

	function mergeArrays($arr1,$arr2,$level = 0){
		foreach($arr1 as $k=>$dummy){
			if($arr2[$k] == 'w'){continue;}
			if($arr1[$k] == 'b'){continue;}
			if($arr2[$k] == 'b' || $arr1[$k] == 'w' && is_array($arr2[$k])){$arr1[$k] = $arr2[$k];continue;}
			$arr1[$k] = mergeArrays($arr1[$k],$arr2[$k],$level++);
		}
		return $arr1;
	}
	function array2string($array = array()){
		$str = '';
		foreach($array as $k=>$v){if(!is_array($v)){$str .= $v;continue;}$str .= 'p';}
		foreach($array as $k=>$v){if(is_array($v)){$str .= array2string($v);}}
		return $str;
	}

	function paintY($arr,$size = 80,$x = 0,$y = 0,$limit = 0){
		$blob = '';
		$isRoot = !$limit;
		if($isRoot){$blob = '<svg style="fill:white;width:'.$size.'px;height:'.$size.'px;">';}
		$limit++;
		foreach($arr as $k=>$a){
			$top = $y;if($k > 1){$top += $size/2;}
			$left = $x;if($k == 0 || $k == 3){$left += $size/2;}
			if(is_array($a)){$blob .= paintY($a,$size/2,$left,$top,$limit);continue;}
			if($a == 'b'){$blob .= '<rect x="'.$left.'px" y="'.$top.'px" width="'.($size/2).'px" height="'.($size/2).'px" fill="black"></rect>';}
		}
		if($isRoot){$blob .= '</svg>';}
		return $blob;
	}
?>
