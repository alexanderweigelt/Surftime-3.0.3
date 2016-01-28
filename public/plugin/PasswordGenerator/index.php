<?php

 /**
 * Plugin Password Generator
 *
 * *Description* Erzeugen von sicheren Passwörtern
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version PLugin PasswordGenerator 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

include_once(dirname(__FILE__).'/classes/PasswordGenerator.php');

\Model\LoadExtensions::AddHTML('library','jQuery');
 
function PasswordGenerator(){
	$password = new PasswordGenerator();
	return $password->viewHTML(); 
}
 
?>