#!/usr/bin/php
<?php
	/* Challenge 16 - Legacy code
	 * by Marcos Fernández (sombra2eternity@gmail.com)
	 */

	$blob = file_get_contents('challenge16.turingCode');
	$states = array();
	$states['start']['#'] = array('stateName'=>'start','stateInput'=>'#','stateOutput'=>'%','stateAction'=>'R','stateCall'=>'state0');
	$blob = str_replace(',end',',stateEnd',$blob);
	$r = preg_match_all('/(?<stateName>state[^,\n]+),(?<stateInput>[^:\n]+):(?<stateOutput>[^,\n]+),(?<stateAction>[^,\n]+),(?<stateCall>[^\n]+)/',$blob,$m);
	foreach($m[0] as $k=>$dummy){
		$state = array('stateName'=>$m['stateName'][$k],'stateInput'=>$m['stateInput'][$k],'stateOutput'=>$m['stateOutput'][$k],'stateAction'=>$m['stateAction'][$k],'stateCall'=>$m['stateCall'][$k]);
		$states[$state['stateName']][$state['stateInput']] = $state;
	}

	/* Finally I understood what the script does, behind the 'exit' you can find some 
	 * code that converts script lines into a php file implementind the logic, it could 
	 * be executed with a simple 'while' bucle anyway (less memory dependant I suppose) */
	$lines = file('php://stdin');
	while($line = array_shift($lines)){
		$cassette = trim($line);
		$cassette = array_diff(explode('#',$cassette),array(''));
		$size = strlen($cassette[1]);
		$cassette = array_map(function($n){return bindec($n);},$cassette);
		$mul = array_shift($cassette);
		$sum = array_sum($cassette);
		echo '#',str_pad(decbin($mul*$sum),$size,'0',STR_PAD_LEFT),'#',PHP_EOL;
	}
exit;

	/* Hmmmm too mucho overhead due to funcions */
	if(0){
		if(!file_exists('challenge16.turing.php')){generateTuring();}
		include_once('challenge16.turing.php');
		$cassette = '#0000000000001100#0000000000010000#00000000000010010#0000001000010100#0000000000010011#';
		$cassette = str_split($cassette);
		start($cassette);
	}

	function generateTuring(){
		$blob = file_get_contents('challenge16.turingCode');
		$states = array();
		$blob = str_replace(',end',',stateEnd',$blob);
		$r = preg_match_all('/state(?<stateNum>[^,\n]+),(?<stateInput>[^:\n]+):(?<stateOutput>[^,\n]+),(?<stateAction>[^,\n]+),(?<stateCall>[^\n]+)/',$blob,$m);
		foreach($m[0] as $k=>$dummy){
			$state = array('stateNum'=>$m['stateNum'][$k],'stateInput'=>$m['stateInput'][$k],'stateOutput'=>$m['stateOutput'][$k],'stateAction'=>$m['stateAction'][$k],'stateCall'=>$m['stateCall'][$k]);
			$states[$state['stateNum']][$state['stateInput']] = $state;
		}

		ob_start();
		echo '<?php '.PHP_EOL.PHP_EOL;
		/* Loader */
		echo 'function start($cassette){$cassette[0] = \'%\';state0($cassette,1);}'.PHP_EOL;
		echo 'function stateEnd($cassette){echo str_replace(\'_\',\'\',$cassette);}'.PHP_EOL;

		ksort($states);
		foreach($states as $k=>$cases){
			echo 'function state'.$k.'($cassette,$pos){'.PHP_EOL;
			//'	echo implode(\'\',$cassette).\' pos \'.$pos.\' \'.__FUNCTION__.PHP_EOL;'.PHP_EOL.
			if(isset($cases['_'])){echo '	if(!isset($cassette[$pos])){$cassette[$pos] = \'_\';}'.PHP_EOL;}
			echo '	switch($cassette[$pos]){'.PHP_EOL;
			foreach($cases as $case){
				echo '		case \''.$case['stateInput'].'\':';
				if($case['stateOutput'] != $case['stateInput']){echo '$cassette[$pos] = \''.$case['stateOutput'].'\';';}
				if($case['stateAction'] == 'R'){echo '$pos++;';}
				if($case['stateAction'] == 'L'){echo '$pos--;';}
				echo 'return '.$case['stateCall'].'($cassette,$pos);'.PHP_EOL;
			}
			echo '	}'.PHP_EOL.
			'	echo \'invalid case on \'.__FUNCTION__;exit;'.PHP_EOL.
			'}'.PHP_EOL.PHP_EOL;
		}
		echo '?>';
		$turing = ob_get_contents();
		ob_end_clean();
		file_put_contents('challenge16.turing.php',$turing);
	}
?>
