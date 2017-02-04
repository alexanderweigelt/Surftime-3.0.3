<?php
    
 /**
 * View Error Document
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace View;


/**
 * Class Error
 * @package View
 */

class Error {

	/**
	 * @param $msg
	 *
	 * @return mixed|string
	 */

	public static function errDocument($msg){
		
		$html = errorMessage($msg);
		return $html;
	}
	
}

?>