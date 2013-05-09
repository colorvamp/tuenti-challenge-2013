#!/usr/bin/php
<?php
	/* Challenge 17 - Silence on the wire
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 * need to insatll gmp php extension
	 */

	$lines = file('php://stdin');
	while($line = array_shift($lines)){
		$num = intval(trim($line));
		$factorial = gmp_fact($num);
		$factorial = str_split(gmp_strval($factorial));
		$factorial = array_sum($factorial);
		echo $factorial.PHP_EOL;
	}

exit;
	/* First I got all the images from the video and crop them to get the light pixels:
	 * - mplayer -vo jpeg:quality=95 video.avi
	 * - gimp -i -b '(batch-crop "*.jpg" 6 22 410 337)' -b '(gimp-quit 0)'
	 * Then I use 'image_process' to convert on/off light to bitstring, once I saw the
	 * headers I user a custom lib for html petitions I made myself to make a petition
	 * including the exposed cookie, that give me the hint to resolve the challenge
	 */

	/* Petition to silence.contest.tuenti.net */
	include_once('challenge17.inc_html.php');
	$r = html_petition('http://silence.contest.tuenti.net',array('cookies'=>array('adminsession'=>'true')));
	print_r($r);

exit;
	/* Get the bits from the image */
	$bitString = array();
	$images = glob('/media/297GB/test/*.jpg');
	foreach($images as $image){
		$val = image_process($image);
		$bitString[] = ($val == 'white') ? 1 : 0;
	}

	/* Decode the string */
	$text = bin2asc($bitString);
	/*GET / HTTP/1.1
	Host: silence.contest.tuenti.net
	Connection: keep-alive
	Cache-Control: max-age=0
	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,/;q=0.8
	User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31
	Accept-Encoding: gzip,deflate,sdch
	Accept-Language: en-US,en;q=0.8
	Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3
	Cookie: adminsession=true*/

	function bin2asc($str){$len = strlen($str);$data = array();for($i=0;$i<$len;$i+=8){$ch=bindec(substr($str,$i,8));$data[]=$ch;}return $data;}

	function image_getResource($path){
		$imgProp = getimagesize($path);
		if($imgProp === false){return false;}
		switch($imgProp['mime']){
			case 'image/jpeg': if(!($image = @imagecreatefromjpeg($path))){return false;}; break;
			default: return false;
		}
		return $image;
	}
	function image_process($imageName){
		$res = image_getResource($imageName);
		imagefilter($res,IMG_FILTER_GRAYSCALE);
		imagefilter($res,IMG_FILTER_CONTRAST,-40);
		$c1 = pixel_getColor($res,5,5);
		$val = ($c1['r'] > 80) ? 'white' : 'black';
		imagedestroy($res);
		return $val;
		//imagepng($res,$imageName.'.png');
	}
	function pixel_getColor($im,$x,$y){$rgb = imagecolorat($im,$x,$y);$r = ($rgb >> 16) & 0xFF;$g = ($rgb >> 8) & 0xFF;$b = $rgb & 0xFF;return array('r'=>$r,'g'=>$g,'b'=>$b);}
	function pixel_isBlank($c){if($c['r'] != 255 || $c['g'] != 255 || $c['b'] != 255){return false;}return true;}
?>
