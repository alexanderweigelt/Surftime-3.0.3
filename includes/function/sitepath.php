<?php

 /**
 * Sitepath
 *
 * *Description* Pfad zum Rootverzeichnis Webserver
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

function sitepath(){
	$root = $_SERVER['DOCUMENT_ROOT'];
	$laenge = strlen($root)-1;
	$erg = substr($root, $laenge );
	
	if ($erg == "/"){
	  	$erg = substr($root, 0,strlen($root)-1);
	  	return str_replace($erg, '', dirname($_SERVER['SCRIPT_FILENAME'])) .'/';
	}
	else{
	  	return str_replace($root, '', dirname($_SERVER['SCRIPT_FILENAME'])) .'/';
	}
}

?>