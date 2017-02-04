<?php
    
 /**
 * Navigation Controller
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace Controller;


/**
 * Class NavController
 * @package Controller
 */

class NavController {
	
	public $entries = array();

	/**
	 * NavController constructor.
	 */

	public function __construct() {
		$this->entries = new \Model\GetContent();
	}
	
	/**
	 * Array Navigation aus Daten DB bilden
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function arrNavigation(){
		
		$nav = [];
		$arr_unset = [];
		$entries = $this->entries->getNavigation();
		
		//Alle vorkommenden Kinderelemente suchen und in Array schreiben
		foreach ($entries as $key)
		{
			$child[] = $key['parent'];
		}
		
		//mehrdimensionalen Array als Grundlage für das Menü bilden
		foreach($entries as $top_nav){			
			if(in_array($top_nav['site_id'], $child)){
				foreach($entries as $key => $sub_nav){
					if($sub_nav['parent'] == $top_nav['site_id']){
						$top_nav['children'][] = $sub_nav;
						$arr_unset[] = $key;
					}
				}
			}
			$nav[] = $top_nav;			
		}
		
		//doppelte Einträge entfernen
		foreach($arr_unset as $unset){
			unset($nav[$unset]);
		}
		
		return $nav;
	}

	/**
	 * Check if the page exists
	 *
	 * @param $site
	 *
	 * @return bool
	 */

	public function checkSite($site){
		
		$is_site = FALSE;
		if($site == 'admin'){
			$is_site = TRUE;
		}
		else{
			foreach($this->entries->getEntries() as $value){
				if($site == $value['page']){
					$is_site = TRUE;
					break;
				}
			}
		}
		return $is_site;
	}
}

?>