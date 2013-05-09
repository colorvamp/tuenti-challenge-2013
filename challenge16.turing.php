<?php 

function start($cassette){$cassette[0] = '%';state0($cassette,1);}
function stateEnd($cassette){echo str_replace('_','',$cassette);}
function state0($cassette,$pos){
	switch($cassette[$pos]){
		case '0':$pos++;return state0($cassette,$pos);
		case '1':$pos++;return state0($cassette,$pos);
		case '#':return state1($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state1($cassette,$pos){
	switch($cassette[$pos]){
		case '#':$pos--;return state1($cassette,$pos);
		case '$':$pos--;return state1($cassette,$pos);
		case '1':$cassette[$pos] = '0';$pos++;return state2($cassette,$pos);
		case '0':$cassette[$pos] = '1';$pos--;return state1($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state2($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos++;return state2($cassette,$pos);
		case '0':$pos++;return state2($cassette,$pos);
		case '#':$pos--;return state3($cassette,$pos);
		case '$':$pos--;return state3($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state3($cassette,$pos){
	switch($cassette[$pos]){
		case '0':$pos--;return state3($cassette,$pos);
		case '1':$pos++;return state4($cassette,$pos);
		case '%':$pos++;return state5($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state4($cassette,$pos){
	switch($cassette[$pos]){
		case '0':$pos++;return state4($cassette,$pos);
		case '1':$pos++;return state4($cassette,$pos);
		case '#':return state7($cassette,$pos);
		case '$':return state7($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state5($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos++;return state5($cassette,$pos);
		case '0':$pos++;return state5($cassette,$pos);
		case '#':return state6($cassette,$pos);
		case '$':return state6($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state6($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state6($cassette,$pos);
		case '0':$pos++;return state6($cassette,$pos);
		case '#':$pos++;return state6($cassette,$pos);
		case '$':$cassette[$pos] = '#';$pos++;return state6($cassette,$pos);
		case '_':$pos--;return state21($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state7($cassette,$pos){
	switch($cassette[$pos]){
		case '#':$cassette[$pos] = '$';$pos++;return state8($cassette,$pos);
		case '$':$pos++;return state9($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state8($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state8($cassette,$pos);
		case '0':$pos++;return state8($cassette,$pos);
		case '#':$pos++;return state8($cassette,$pos);
		case '_':$pos--;return state10($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state9($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$cassette[$pos] = '_';$pos++;return state12($cassette,$pos);
		case '0':$cassette[$pos] = '_';$pos++;return state13($cassette,$pos);
		case '#':$cassette[$pos] = '_';$pos++;return state14($cassette,$pos);
		case '$':return state15($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state10($cassette,$pos){
	switch($cassette[$pos]){
		case '#':$cassette[$pos] = '$';$pos--;return state11($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state11($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos--;return state11($cassette,$pos);
		case '0':$pos--;return state11($cassette,$pos);
		case '#':$pos--;return state11($cassette,$pos);
		case '$':$pos++;return state9($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state12($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state12($cassette,$pos);
		case '0':$pos++;return state12($cassette,$pos);
		case '#':$pos++;return state12($cassette,$pos);
		case '$':$pos++;return state12($cassette,$pos);
		case '_':$cassette[$pos] = '1';$pos--;return state16($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state13($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state13($cassette,$pos);
		case '0':$pos++;return state13($cassette,$pos);
		case '#':$pos++;return state13($cassette,$pos);
		case '$':$pos++;return state13($cassette,$pos);
		case '_':$cassette[$pos] = '0';$pos--;return state17($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state14($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state14($cassette,$pos);
		case '0':$pos++;return state14($cassette,$pos);
		case '#':$pos++;return state14($cassette,$pos);
		case '$':$pos++;return state14($cassette,$pos);
		case '_':$cassette[$pos] = '#';$pos--;return state18($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state15($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state15($cassette,$pos);
		case '0':$pos++;return state15($cassette,$pos);
		case '#':$pos++;return state15($cassette,$pos);
		case '$':$pos++;return state15($cassette,$pos);
		case '_':$cassette[$pos] = '#';$pos--;return state19($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state16($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos--;return state16($cassette,$pos);
		case '0':$pos--;return state16($cassette,$pos);
		case '#':$pos--;return state16($cassette,$pos);
		case '$':$pos--;return state16($cassette,$pos);
		case '_':$cassette[$pos] = '1';$pos++;return state9($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state17($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos--;return state17($cassette,$pos);
		case '0':$pos--;return state17($cassette,$pos);
		case '#':$pos--;return state17($cassette,$pos);
		case '$':$pos--;return state17($cassette,$pos);
		case '_':$cassette[$pos] = '0';$pos++;return state9($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state18($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos--;return state18($cassette,$pos);
		case '0':$pos--;return state18($cassette,$pos);
		case '#':$pos--;return state18($cassette,$pos);
		case '$':$pos--;return state18($cassette,$pos);
		case '_':$cassette[$pos] = '#';$pos++;return state9($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state19($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos--;return state19($cassette,$pos);
		case '0':$pos--;return state19($cassette,$pos);
		case '#':$pos--;return state19($cassette,$pos);
		case '$':$pos--;return state20($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state20($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos--;return state20($cassette,$pos);
		case '0':$pos--;return state20($cassette,$pos);
		case '#':$pos--;return state20($cassette,$pos);
		case '$':return state1($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state21($cassette,$pos){
	switch($cassette[$pos]){
		case '#':$pos--;return state22($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state22($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos--;return state22($cassette,$pos);
		case '0':$pos--;return state22($cassette,$pos);
		case '#':$pos--;return state23($cassette,$pos);
		case '%':$cassette[$pos] = '#';return stateEnd($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state23($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state23($cassette,$pos);
		case '0':$pos++;return state23($cassette,$pos);
		case '#':$pos++;return state23($cassette,$pos);
		case '_':$pos--;return state24($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state24($cassette,$pos){
	switch($cassette[$pos]){
		case '#':$pos--;return state25($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state25($cassette,$pos){
	switch($cassette[$pos]){
		case '0':$pos--;return state25($cassette,$pos);
		case '1':$pos++;return state26($cassette,$pos);
		case '#':$pos++;return state27($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state26($cassette,$pos){
	switch($cassette[$pos]){
		case '0':$pos++;return state26($cassette,$pos);
		case '1':$pos++;return state26($cassette,$pos);
		case '#':$pos--;return state29($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state27($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos++;return state27($cassette,$pos);
		case '0':$pos++;return state27($cassette,$pos);
		case '#':$cassette[$pos] = '_';$pos--;return state28($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state28($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$cassette[$pos] = '_';$pos--;return state28($cassette,$pos);
		case '0':$cassette[$pos] = '_';$pos--;return state28($cassette,$pos);
		case '#':return state21($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state29($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$cassette[$pos] = '0';$pos--;return state30($cassette,$pos);
		case '0':$cassette[$pos] = '1';$pos--;return state29($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state30($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$pos--;return state30($cassette,$pos);
		case '0':$pos--;return state30($cassette,$pos);
		case '#':$pos--;return state31($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state31($cassette,$pos){
	switch($cassette[$pos]){
		case '1':$cassette[$pos] = '0';$pos--;return state31($cassette,$pos);
		case '0':$cassette[$pos] = '1';$pos++;return state32($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

function state32($cassette,$pos){
	if(!isset($cassette[$pos])){$cassette[$pos] = '_';}
	switch($cassette[$pos]){
		case '1':$pos++;return state32($cassette,$pos);
		case '0':$pos++;return state32($cassette,$pos);
		case '#':$pos++;return state32($cassette,$pos);
		case '_':$pos--;return state21($cassette,$pos);
	}
	echo 'invalid case on '.__FUNCTION__;exit;
}

?>