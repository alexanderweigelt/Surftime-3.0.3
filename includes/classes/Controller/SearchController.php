<?php
    
 /**
 * Search Controller
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class SearchController {

	public $response;
	
/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	public function __construct(){
		$this->result = new \Model\SearchModel();
	}

/**
 * Volltextsuche ausfuehren 
 *
 * *Description* 
 * 
 * @param $term string, $page string
 *
 * @return string
 */
 
	public function startSearch($term = NULL, $page){
		if(!empty($term)){
			if($page == 'search'){
				//Ergebnisse aus DB Tabelle holen
				$searchRequest = $this->result->getSearch($term);
				$arrResult = array();
				foreach($searchRequest as $key => $value){
					$arrResult[$key] = preg_replace('/{%\S*%}/', '', $value);
				}
				//Suchergebnis zurück geben
				return \View\Search::ViewResult($arrResult);
			}
			else{
				$term = \Controller\Helpers::Clean($term);
				if(!URL_REWRITING){
					$s = '&';
				}
				else{
					$s = '?';
				}
				if(!empty($_GET)){
					foreach($_GET as $k => $v){
						if($k != 'site'){
							$param .= '&'.$k.'='.$v;
						}
					}
				}
				$filename = \Controller\Helpers::buildLink('search').$s.$param;
				$this->response->modifyHeader('location', $filename, TRUE);
			}
		}
	}	
}

?>