<?php
    
 /**
 * View Search Result
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
 * Class Search
 * @package View
 */

class Search {

	/**
	 * @param $arrRequest
	 *
	 * @return string
	 */

	public static function ViewResult($arrRequest){
		
		$result = '
		<ol>';
		if(!empty($arrRequest)){
			foreach($arrRequest as $request){
				// Inhalt auf 250 Zeichen kuerzen
				$shortcontent = $request['content'];
				$shortcontent = strip_tags($shortcontent);
				$shortcontent = preg_replace("/(?<=.{250}?\\b)(.*)/is", "&hellip;", $shortcontent);
				$result.= '
			<li>
				<a href="'.\Controller\Helpers::buildLink($request['page']).'">'.$request['headline'].'</a>
				<span>'.$shortcontent.'</span>
			</li>';
			}
		}
		else{
			$result.= '
			<li>Kein Ergebnis</li>';	
		}
		$result.= '
		</ol>';
		
		return $result;
	}
	
}

?>