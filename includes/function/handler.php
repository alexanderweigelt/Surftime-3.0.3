<?php

function handler($buffer,$mode){
	$buffer=ob_gzhandler($buffer,$mode);
	return $buffer;
}

?>