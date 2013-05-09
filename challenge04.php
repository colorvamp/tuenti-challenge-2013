#!/usr/bin/php
<?php
	/* Challenge 4 - Missing numbers
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	/* HOW-IT-WORKS: I think this challenge is unfair, everybody smart enought will process (order) the file
	 * from RAM if possible, the major inconvenience is the 8Gb file you need to store in your ram memory, but there
	 * are people out there with 16GB, even 32GB of ram, this is a great disadvantage for the others with a very
	 * modest installations, in other words this challenge is about money, if you are richer with super cool pc you
	 * have earn the biggest part of it.
	 *
	 * I have tried to short this diference as much as I can. I could have make a simple quicksort algorith to work 
	 * against the file stored in disk, but in the worst posible scenario (for example most of the rows reversed) this
	 * would take too much hours procesing, and time runs out so I decided to split the file in 10 small workloads, 
	 * the main problem you face is the disc write performance, problem you dont have with several Gb of ram. I decided
	 * every workload could output to a (almost) diferent device, like RAID drives, the more write heads you have
	 * the more performance you get. Once the task is split, I needed to create dummy blobs.
	 * Taking an integer and with the premise that the previous ones are in order you know the right position in file
	 * and in wich file they must be (integer*4 = offset), then I only need to read original 'integer' file once and write 
	 * each row to the right sorted file position. The function I created to fill dummy blobs directly link some
	 * duummy files in my ram folder, up to the size of my computer (I cant storage 8GB but a fraction is still a big gain), I 
	 * manually symlinked a few others blobs in pendrives, fast cameras SDs and externals drives to merge as much write 
	 * power as I could.
	 * Then I only needed to create some threads to read the original file from diferents parts at a time and walk
	 * the integers to the blob files in the right position.
	 * I added too a simply way to store some checkpoints in files and be able to resume/stop the running workloads.
	 * When all the workloads finished the result file must be ordered, but in parts, I still have to make some command 
	 * like 'cat * > final' to gen a unitary blob containing all integers in order. Once the file is merged I can
	 * read it in a linear way counting the pos and the numbers that have gone. Im gonna do it once and cache the result
	 * for a better performance when the 'test challenge' or the 'submit challenge' asks, but I leave all the functions
	 * used before in the file. */

	/* usage: 
		php challenge04.php sortFile integers [0-9] &
		cd cache && cat dummy* > bigDummy
		php challenge04.php numbersLeft
	 */
	if(isset($argv[1]) && function_exists($argv[1])){
                array_shift($argv);
                $command = array_shift($argv);
                call_user_func_array($command,$argv);
        }

	if(file_exists('leftNums')){
		$leftNums = explode(PHP_EOL,file_get_contents('leftNums'));
		$i = file('php://stdin');
		array_shift($i);
		while($pos = array_shift($i)){
			echo $leftNums[intval($pos)].PHP_EOL;
		}
		exit;
	}

	//generateTest();
	function generateTest(){
		$nums = array();
		$limit = 500000;while($limit--){$nums[] = $limit;}$nums = array_values(array_reverse($nums));
		unset($nums[1008],$nums[2000]);
		shuffle($nums);

		$fp = fopen('testInt','cb');
		foreach($nums as $num){fwrite($fp,pack('I',$num));}
		fclose($fp);
	}

	//sortFile();
	//function sortFile($sourceFile = 'testInt',$part = 0,$totalNums = 500000){
	//totalnums = 2147483647+3
	function sortFile($sourceFile = 'integers',$part = 0,$totalNums = 2147483650){
		if($part < 0 || $part > 9){return false;}
		$totalSize = $totalNums*4;
		$fractionNums = $totalNums/10;
		$fractionSize = $totalSize/10;
		/* Begining and ending num */
		$startNum = $fractionNums*$part;$endNum = ($startNum+$fractionNums-1);//echo $startNum.' '.$endNum;exit;
		/* Begining offset */
		$startOffset = $startNum*4;
		$counter = $fractionNums;
		$saveAt = 500000;

		/* We create the dummy files */
		$dummyFile = 'cache/dummy';
		$fileParts = array();$i = 10;while($i--){
			$fileName = $dummyFile.$i;
			if(!file_exists($fileName)){$r = @shell_exec('dd if=/dev/zero of='.$fileName.' bs=1 count=1 seek='.($fractionSize-1));}
			$fileParts[$i] = fopen($dummyFile.$i,'cb');
		}

		$src = fopen($sourceFile,'rb');fseek($src,$startOffset);
		if(file_exists('saveState'.$part)){fseek($src,file_get_contents('saveState'.$part));}/* For resume */
		//$dst = fopen('dummy','cb');
		$c = 0;while(!feof($src) && $counter--){
			$c++;
			$int = fread($src,4);if(feof($src)){break;}
			list(,$number) = unpack('I',$int);
			$fileNum = floor($number/$fractionNums);
			$localStart = ($fractionNums*$fileNum*4);
			$localPosition = $number*4;
			$localPosition -= $localStart;
			fseek($fileParts[$fileNum],$localPosition);
			fwrite($fileParts[$fileNum],$int);
			//fseek($dst,$localPosition);
			//fwrite($dst,$int);
			if($c > $saveAt){
				$r = file_put_contents('saveState'.$part,ftell($src),LOCK_EX);/* For resume if necesary */
				echo ($fractionNums-$counter).'/'.$fractionNums.' ('.round((($fractionNums-$counter)/$fractionNums)*100,2).')'.PHP_EOL;
				if(file_exists('stop')){exit;}
				$c = 0;
			}
		}
		fclose($src);
		foreach($fileParts as $k=>$file){fclose($file);}
		//fclose($dst);
	}

	//numbersLeft();
	function numbersLeft($part = false){
		$file = 'cache/dummy';
		if($part !== false){$file .= $part;}
		$total = 0;
		$src = fopen($file,'rb');
		$c = -1;$oldnumber = false;while(!feof($src)){$c++;
			$int = fread($src,4);if(feof($src)){break;}
			list(,$number) = unpack("I",$int);
			if(empty($number)){/* 0 num will enter too but its ok */
				$total++;
				$fp = fopen('cache/leftNums','a');fwrite($fp,$c.PHP_EOL);fclose($fp);
				//echo 'skip '.$c.' ('.ftell($src).') old('.$oldnumber.') '."\n";/**/continue;
			}
			//if($oldnumber && $oldnumber > $number){echo 'fallo: mayor';exit;}
			//echo $number.' -> '.$localPosition.' ('.$fileNum.') -> '.(ftell($src)-4)."\n";
			$oldnumber = $number;
			//*/
		}
		fclose($src);
		echo $total."\n";
	}
exit;
?>
