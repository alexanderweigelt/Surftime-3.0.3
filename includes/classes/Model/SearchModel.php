<?php
    
 /**
 * Loading Search Results
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class SearchModel extends \Model\ConnectDB {
	
	/** Eigenschaften definieren */
	public $db;
	
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
		$this->db = parent::connect();
	}
	
/**
 * Suche Datenbank 
 *
 * *Description* Volltextsuche ausfuehren
 * 
 * @param string
 *
 * @return array
 */
 
	public function getSearch($term){
		
		$sqlQuery = "
			SELECT page, headline, content
			 
			FROM ".TBL_PRFX."site
			
			WHERE MATCH (headline, content)
			
			AGAINST (:term)";
		$stmt = $this->db->prepare($sqlQuery);
		$stmt->execute(
			array(':term' => $term)
		);
		$request = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		
		return $request;
	}
	
}

?>