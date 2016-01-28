<?php
    
 /**
 * Install CMS Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class InstallModel extends \Model\ConnectDB {

	/** Install Settings */
	const DEFAULT_PASS = 'webmaster';
	const DEFAULT_USER = 'webmaster';
	
	/** Eigenschaften definieren */
	private $arrData;
	private $pass;
		
/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param 
 *
 * @return 
 */
 
	public function __construct() {
		$this->db = parent::connect();
		$this->pass = \Controller\Helpers::encryptPassword(self::DEFAULT_PASS);
		$this->arrData = $this->loadInsertDatabase();
	}
	
/**
 * Installtion, Erstellen von Datenbanktabellen ausfuehren 
 *
 * *Description* 
 * 
 * @param string
 *
 * @return 
 */
 
	public function runInstallation(){
		
		// Array Message
		$successInstallation = array(
			'error' => NULL,
			'message' => 'Successfully Insert in Table'
		);
		
		// durchlaufe Array mit MySQL-Query Create Table
		foreach(parent::dbStrukture() as $table => $query){
			
			// Lösche Tabelle
			$this->db->query('DROP TABLE IF EXISTS '.TBL_PRFX.$table);
			
			// Neue Tabelle in Datenbank erstellen
			if($this->db->query($query['create'])){ 
				
				// durchlaufe Array mit MySQL-Query Insert Into
				$stmt = $this->db->prepare($query['insert']);
				foreach($this->arrData[$table] as $arrExec){
					$insertTable = $stmt->execute($arrExec);
				}
				
				// Meldung Eintrag erfolgreich
				if($insertTable){ 
					$successInstallation = array(
						'error' => false,
						'message' => $successInstallation['message'].' +'.$table
					);
				}
				else{
					// Fehlermeldung Abbruch bei Tabelle ...
					$successInstallation = array(
						'error' => true,
						'message' => 'Insert canceled at Table '.$table
					);
				}
			}
			else{
				// Fehlermeldung Abbruch bei Tabelle ...
				$successInstallation = array(
					'error' => true,
					'message' => 'Create canceled at Table '.$table
				);
				break;
			}
		}
		
		if(!$successInstallation['error']){
			
			$robots = PROJECT_ROOT.'robots.txt';
			if(file_exists($robots)){
				unlink($robots);
			}
			
			$sitemap = URL_REWRITING ? \Controller\Helpers::getHost().'/sitemap.xml' : \Controller\Helpers::getHost().'/xml.php?site=sitemap';
			$datei = fopen($robots, 'w');
			fwrite($datei, "Sitemap: ".$sitemap."\r\n\r\nUser-agent: *\r\nDisallow:",100);
			fclose($datei);
		}
			
		return $successInstallation;
	}
	
/**
 * Seiteninhalte aus XML laden
 *
 * *Description* Lädt die Daten aus einer XML Datei und wandelt diese in einen Execute-Array um.
 * 
 * @param 
 *
 * @return array
 */
 
	private function loadInsertDatabase(){
		
		$error = FALSE;
		$values = array();
		
		if(file_exists(SYSTEM_FILES.'system-pages.xml')){
			$objectXML = simplexml_load_file(SYSTEM_FILES.'system-pages.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
			if($objectXML !==  FALSE){ 
				/** Importing Content Into Array */
				$arrXML = objectToArray($objectXML);
				foreach(parent::dbStrukture('tables') as $table) {
					$i = 0;
					if(!empty($arrXML[$table]['insert'])){
						foreach($arrXML[$table]['insert'] as $key => $value){
							if(is_array($value)){
								foreach($value as $row => $content){
									$values[$table][$i][':'.$row] = !empty($content) ? $this->compileData(trim($content)) : '';
								}
							}
							else{
								$values[$table][0][':'.$key] = !empty($value) ? $this->compileData(trim($value)) : '';
							}
							$i++;
						}
					}
					else{
						$error = TRUE;
					}
				}
			}
		}
	
		if(!$error){
			return $values;
		}
		else{
			exit('XML Data is missing');
		}	
	}

/**
 * Platzhalter aus XML-Datei ersetzen
 *
 * *Description* Tauscht den jeweiligen Platzhalter im Text der XML-Datei gegen den entsprechenden Wert.
 * 
 * @param string
 *
 * @return string
 */
 	
	public function compileData($text){
		
		// Such-Parameter (Platzhalter im Text)
		$arrSearch = array(
			'[[%DATE%]]',
			'[[%HTTP-HOST%]]',
			'[[%TIMESTAMP%]]',
			'[[%USERNAME%]]',
			'[[%PASSWORD%]]'
					);
			
		// Ersetzungs-Parameter (Variablen von außerhalb der Funktion)
		$arrReplace = array(
			date('Y-m-d'), 
			$_SERVER['HTTP_HOST'],
			date('Y-m-d H:i:s'),
			self::DEFAULT_USER,
			$this->pass
					);
					
		// Suchen & Ersetzen im Content
		$content = str_replace($arrSearch, $arrReplace, $text);	
				
		return $content;
	}
}

?>