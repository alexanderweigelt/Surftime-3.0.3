<?php

 /**
 * Plugin SEPA Tool
 *
 * *Description* Umrechnung von Kontonummer und BLZ in IBAN
 * Das Plugin funktioniert nur für die Erzeugung aus einem deutschen Konto
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version PLugin SEPA Tool 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

include_once(dirname(__FILE__).'/classes/PasswordGenerator.php'); 

function AjaxData($param){
	$password = new PasswordGenerator();
	return $password->getAjaxData($param);
}

?>