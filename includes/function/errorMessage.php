<?php

 /**
 * Fehlermeldung
 *
 * *Description* Compiliere Simple Fehlermeldung als HTML Error-Document
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

function errorMessage($msg){
	
	$unknow = 'An unknown mistake has appeared ';
	if(defined('DEBUG_MODE') and DEBUG_MODE){
		$message = (!empty($msg)) ? (string)$msg : $unknow;
	}
	else{
		$message = $unknow;
	}
	if(file_exists(PATH_PAGES.ERRORPAGE)){
		$html = str_replace('{%ERROR%}', $message, file_get_contents(PATH_PAGES.ERRORPAGE));
	}
	else{
		$html = '<strong>Warning:</strong> '.$message.' !';
	}
	return $html;
}

?>