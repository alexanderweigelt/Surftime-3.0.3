<?php
    
 /**
 * Model loads content from DB
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace Model;


/**
 * Class GetContent
 * @package Model
 */

class GetContent extends \Model\ConnectDB {
	
	/** Properties */
	public $db;
	public $entries = array();


	/**
	 * GetContent constructor.
	 */

	public function __construct(){
		$this->db = parent::connect();
	}
	
	/**
	 * Datenbank pruefen
	 *
	 * *Description* Pruefe bei Systemstart ob alle notwendigen Tabellen und Spalten angelegt sind
	 *
	 * @param string
	 *
	 * @return array
	 */
 
	public function checkDB($setting = 'complete'){
		
		$missing = array('error' => FALSE, 'message' => NULL);
		$tableCols = parent::dbStrukture('cols');
		
		// Prüfe ob Tabellen existieren
		$stmt = $this->db->query("SHOW TABLES");
		$tables = $stmt->fetchAll(\PDO::FETCH_ASSOC);	
		if(!empty($tables)){
			foreach(parent::dbStrukture('tables') as $table){
				if(in_array_r(TBL_PRFX.$table, $tables)){
					
					// Prüfe ob alle Spalten existieren bei complete
					if($setting != 'short'){
						
						$stmt = $this->db->query("SHOW COLUMNS FROM ".TBL_PRFX.$table);
						$columns = $stmt->fetchAll(\PDO::FETCH_COLUMN);
						
						if(!empty($columns)){
							foreach($tableCols[$table] as $column){	
								if(!in_array_r($column, $columns)){
									$missing['message'][] = 'missing column '.$column.' in table '.$table;
								}
							}
						}
						else{
							$missing['message'][] = 'missing all cols in table '.$table;
						}
					}
				}
				else{
					$missing['message'][] = 'missing table '.$table;
				}
			}
		}
		else{
			$missing['message'][] = 'missing all tables';
		}
		
		if(!empty($missing['message'])){
			$missing['error'] = TRUE;
		}
		return $missing;
	}
	
	/**
	 * Eintrag Seite holen
	 *
	 * *Description* Einzelne Seite aus Tabelle site DB holen
	 *
	 * @param string
	 *
	 * @return array
	 */
 
	public function getEntry($page){
		$sql_request = "SELECT * FROM ".TBL_PRFX."site s LEFT JOIN ".TBL_PRFX."meta m ON m.page_id = s.id LEFT JOIN ".TBL_PRFX."navigation n ON m.page_id = n.site_id WHERE s.page = :page";
		$stmt = $this->db->prepare($sql_request);
		$stmt->execute(
			array(':page' => $page)
		);
		$request = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(!empty($request)){
			return $request;
		}
		else{
			return array_merge($this->getColumns(TBL_PRFX.'site'), $this->getColumns(TBL_PRFX.'meta'), $this->getColumns(TBL_PRFX.'navigation'));
		}
	}
	
	/**
	 * Alle Eintraege von Seiten holen
	 *
	 * *Description* Alle Seiten aus Tabelle site DB holen
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function getEntries(){
		$sql_request = "SELECT * FROM ".TBL_PRFX."site s LEFT JOIN ".TBL_PRFX."meta m ON m.page_id = s.id";
		$stmt = $this->db->query($sql_request);
		$request = $stmt->fetchAll();
		if(!empty($request)){
			return $request;
		}
		else{
			return array_merge($this->getColumns(TBL_PRFX.'site'), $this->getColumns(TBL_PRFX.'meta'));
		}
	}

	/**
	 * Daten Panel holen
	 *
	 * *Description* Einzelne (3) Panel aus Tabelle panel DB holen
	 *
	 * @param
	 *
	 * @return array
	 */
	
	public function getPanel(){
		$sql_request = "SELECT number, last_modified, widget FROM ".TBL_PRFX."panel";
		
		$stmt = $this->db->prepare($sql_request);
		$stmt->execute();
		$request = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		if(!empty($request)){
			return $request;
		}
		else{
			return $this->getColumns(TBL_PRFX.'panel');
		}
	}
	
	/**
	 * Daten Benutzer holen
	 *
	 * *Description* Einzelne Benutzerdaten aus Tabelle user DB holen
	 *
	 * @param string
	 *
	 * @return array
	 */
 
	public function getUserData($username = ''){
		
		$sql_request = "SELECT * FROM ".TBL_PRFX."user WHERE username = :username";
		$arr_request = array(':username' => $username);		
		
		$stmt = $this->db->prepare($sql_request);
		$stmt->execute(
			$arr_request
		);
		$request = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(!empty($request)){
			return $request;
		}
		else{
			return $this->getColumns(TBL_PRFX.'user');
		}
	}
	
	/**
	 * Alle Eintraege von Benutzern holen
	 *
	 * *Description* Alle Benutzer aus Tabelle user DB holen
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function getAllUsers(){
		$sql_request = "SELECT id, email, username, registration_date, status FROM ".TBL_PRFX."user";
		
		$stmt = $this->db->prepare($sql_request);
		$stmt->execute();
		$request = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		if(!empty($request)){
			return $request;
		}
		else{
			return $this->getColumns(TBL_PRFX.'user');
		}
	}
	
	/**
	 * Variablen auslesen
	 *
	 * *Description* Alle Variablen aus Tabelle settings DB holen
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function getSiteSettings(){
		$sql_request = "SELECT * FROM ".TBL_PRFX."settings WHERE var_id = 1";
		$stmt = $this->db->query($sql_request);
		$request = $stmt->fetch();
		if(!empty($request)){
			return $request;
		}
		else{
			return $this->getColumns(TBL_PRFX.'settings');
		}	
	}
	
	/**
	 * Navigation auslesen
	 *
	 * *Description* Alle Daten der Navigaton aus Tabellen site und navigation DB holen
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function getNavigation(){
		$sql_request = "SELECT parent, anchor, page, site_id, title, sorting FROM ".TBL_PRFX."site s LEFT JOIN ".TBL_PRFX."navigation n ON n.site_id = s.id LEFT JOIN ".TBL_PRFX."meta m ON s.id = m.page_id ORDER BY n.sorting";
		$stmt = $this->db->query($sql_request);
		$request = $stmt -> fetchAll();
		if(!empty($request)){
			return $request;
		}
		else{
			return array_merge($this->getColumns(TBL_PRFX.'site'), $this->getColumns(TBL_PRFX.'meta'));
		}
	}


    /**
	 * Einstellungen von System holen
	 *
	 * *Description* Alle Einstellungen aus Tabelle settings DB holen
	 *
	 * @param
	 *
	 * @return array
	 */

	public function getSetup(){
		$sql_request = "SELECT * FROM ".TBL_PRFX."setup WHERE set_id = 1";
		$stmt = $this->db->query($sql_request);
		$request = $stmt->fetch();
		if(!empty($request)){
			return $request;
		}
		else{
			return $this->getColumns(TBL_PRFX.'setup');
		}
	}
	
	/**
	 * Spalten einer Tabelle auslesen
	 *
	 * *Description*
	 *
	 * @param string
	 *
	 * @return array
	 */
 
	private function getColumns($tablename) {
		$columns = array();
		if($tablename){
			$sql_request = "DESCRIBE ".$tablename;
			$stmt = $this->db->query($sql_request);
			$table_names = $stmt->fetchAll(\PDO::FETCH_COLUMN);
			if(!empty($table_names)){
				foreach($table_names as $name){
					$columns[$name] = '';
				}
			}
		}
		return $columns;
	}
	
	/**
	 * ENUM und SET lesen
	 *
	 * *Description* Holt ENUM und SET Felder aus einer Tabelle
	 *
	 * @param string, string
	 *
	 * @return array
	 */
 
	public function getDBEnumSet($db_tbl,$db_field) {
		
		$db_tbl = TBL_PRFX.$db_tbl;
		$arr_values = array();
		$arrExec = array( 
				':field' => $db_field
			);	
		$stmt = $this->db->query("SHOW TABLES");
		$tables = $stmt->fetchAll(\PDO::FETCH_ASSOC);	
		foreach ($tables as $value){
			if(in_array($db_tbl, $value)) {
				$table = $value;
				break;
			}
		}
		
		if($table){
			$sql = "SHOW COLUMNS FROM ".$db_tbl." LIKE :field ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute($arrExec);
			$row = $stmt->fetch(\PDO::FETCH_NUM);
			if(!empty($row)) {  
				$arr_values =  explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
			}
		}
		return $arr_values;
	}
	
	/**
	 * Bilder einlesen
	 *
	 * *Description* Hole alle Bilder aus den Ordner Thumb und Big und schreibe Pfade in Array
	 *
	 * @param string, string
	 *
	 * @return array
	 */
 
	public function getAllImages(){

		$allImages = array();
		$i = 0;
		foreach(glob(DIR_IMAGES_BIG.'*.[jpg][png][gif]') as $file){
			$path_parts = pathinfo($file);  
			$allImages[$i]['thumb'] = DIR_IMAGES_THUMBNAILS.$path_parts['basename'];
			$allImages[$i]['large'] = $file;
			$allImages[$i]['basename'] = $path_parts['basename'];
			$allImages[$i]['alt'] = str_replace('-', ' ', $path_parts['filename']); 
			$i++; 
		}	
		return $allImages;
	}

	/**
	 * Templates einlesen
	 *
	 * *Description* Lese alle vorhandenen Templates aus und validiere diese
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function getAllTemplates(){
	
		$allTemplates = array();
		foreach(glob(THEME_DIR.'*') as $tpl){
			if(file_exists($tpl.'/index.tpl.php')){
				$screenshot = file_exists($tpl.'/screenshot.png') ? $tpl.'/screenshot.png' : DIR_ADMIN.'img/screenshot.png';
				$explPath = explode('/', $tpl);
				$name = array_pop($explPath);
				$settings = $this->getSetup();
				$isactiv = $settings['template'] == $name ? TRUE : FALSE;
				$info = file_exists($tpl.'/readme.txt') ? file_get_contents($tpl.'/readme.txt') : 'Keine Informationen hinterlegt!';
				$arrTPL = array(
					'file' => $name,
					'name' => ucfirst($name),
					'path' => $tpl,
					'screenshot' => $screenshot,
					'activ' => $isactiv,
					'info' => $info
				);
				$allTemplates[] = $arrTPL;
			}
		}
		return $allTemplates;
	}
	
	/**
	 * Rechte eines Benutzer feststellen
	 *
	 * *Description* Lese aus der Session die gesetzten Rechte eines eingeloggten Benutzers
	 *
	 * @param
	 *
	 * @return string or boolean
	 */
 
	public function getRole(){
		
		$role = isset($_SESSION['role']) ? $_SESSION['role'] : FALSE;
		return $role;	
	}
	
	/**
	 * Systeminformationen
	 *
	 * *Description* Lese Infos vom System aus hinterlegter XML-Datei
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function readSystemInfos(){
		
		$system = array(    
			'cms' => array(
					'name' => '',
					'version' => '',
					'author' => '',
					'creation_date' => ''
				),
		
			'info' => array(
					'support' => '',
					'newsfeed' => ''
				),
		
			'license' => array(
					'agreement' => '',
					'legalcode' => '',
					'terms' => ''
				),
		
			'meta' => array(
					'title' => ''
				)
		);
		
		if(file_exists(SYSTEM_FILES.'system-info.xml')){
			
			$objectXML = simplexml_load_file(SYSTEM_FILES.'system-info.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
			$arrXML = objectToArray($objectXML);
			if(!empty($arrXML)){
				$system = $arrXML;
			}
		}
		
		return $system;
	}
}

?>