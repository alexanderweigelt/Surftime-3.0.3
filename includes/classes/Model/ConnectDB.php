<?php
    
 /**
 * Connect Database Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class ConnectDB {
	
/** Eigenschaften definieren */
	
	public static $charset;
	
/**
 * Datenbankverbindung herstellen
 *
 * *Description* Methode ohne instanziieren der Klasse aufrufen
 * 
 * @param
 *
 * @return object 
 */
 
 	public static function connect(){
		
		self::setMySQLCharset();
		//Aufbau der Datenbankverbindung
		try {
			$db = new \PDO('mysql:host='.DB_HOST.self::setMySQLPort().';dbname='.DB_NAME, DB_USER, DB_PASS,
				array(
					// SET ATTRIBUTE
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "'.self::$charset.'"',				
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
			));
			$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
			return $db;	
		}
		catch(\PDOException $ex) {
            //Fehler
			$error = \View\Error::errDocument($ex->getMessage());
            exit($error);
		}
			 
	}
	
/**
 * Zeichensatz DB setzen
 *
 * *Description* Globalen Zeichensatz verwenden
 * 
 * @param
 *
 * @return string 
 */
 
 	private static function setMySQLCharset(){
		self::$charset = \Framework\Utility::getCharset(1);
	}

	
/**
 * MySQL Port setzen
 *
 * *Description* Port bei Angabe Konstante DB_PORT setzen
 * 
 * @param
 *
 * @return string 
 */
 
 	private static function setMySQLPort(){
		$port = defined('DB_PORT') ? ';port='.DB_PORT : '';
		return $port;
	}
		
/**
 * Datenbankstruktur abbilden
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	public function dbStrukture($select = NULL){
	
		$arrTables = array();
		
		// database structure
		$dbStructure = array(
			
			/* Tabellenstruktur für Tabelle meta */
			'meta' => array(
				/* Spalten Table meta */
				'cols' => array('_id', 'page_id', 'indexation', 'title', 'keywords', 'description'),
				/* MySQL Query Table meta */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."meta (
						  _id int(11) NOT NULL AUTO_INCREMENT,
						  page_id int(11) NOT NULL,
						  indexation enum('index','noindex') NOT NULL DEFAULT 'index',
						  title varchar(255) NOT NULL,
						  keywords varchar(255) NOT NULL,
						  description varchar(255) NOT NULL,
						  PRIMARY KEY (_id)
						) ENGINE=MyISAM  DEFAULT CHARSET=".self::$charset." COMMENT='Metadaten'",
				/* Daten für Tabelle meta */
				'insert' => "
						INSERT INTO ".TBL_PRFX."meta (page_id, indexation, title, keywords, description) VALUES
							(:page_id, :indexation, :title, :keywords, :description)"
			),
			
			/* Tabellenstruktur für Tabelle navigation */	
			'navigation' => array(
				/* Spalten Table navigation */
				'cols' => array('_id', 'site_id', 'sorting', 'parent', 'anchor'),
				/* MySQL Query Table navigation */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."navigation (
						  _id int(11) NOT NULL AUTO_INCREMENT,
						  site_id int(11) NOT NULL,
						  sorting int(11) NOT NULL,
						  parent int(11) NOT NULL,
						  anchor varchar(255) NOT NULL,
						  PRIMARY KEY (_id)
						) ENGINE=MyISAM  DEFAULT CHARSET=".self::$charset." COMMENT='Navigation'",
				/* Daten für Tabelle navigation */
				'insert' => "
						INSERT INTO ".TBL_PRFX."navigation (site_id, sorting, parent, anchor) VALUES
							(:site_id, :sorting, :parent, :anchor)"
			),
			
			/* Tabellenstruktur für Tabelle settings */
			'settings' => array(
				/* Spalten Table settings */
				'cols' => array('var_id', 'slogan', 'firstname', 'lastname', 'street', 'postalzip', 'city', 'phone', 'email', 'company', 'opening', 'variable'),
				/* MySQL Query Table settings */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."settings (
						  var_id int(11) NOT NULL,
						  slogan varchar(255) NOT NULL,
						  firstname varchar(255) NOT NULL,
						  lastname varchar(255) NOT NULL,
						  street varchar(255) NOT NULL,
						  postalzip varchar(5) NOT NULL,
						  city varchar(255) NOT NULL,
						  phone varchar(255) NOT NULL,
						  email varchar(190) NOT NULL,
						  company varchar(255) NOT NULL,
						  opening varchar(255) NOT NULL,
						  variable varchar(255) NOT NULL,
						  PRIMARY KEY (var_id),
						  UNIQUE KEY id (var_id)
						) ENGINE=MyISAM DEFAULT CHARSET=".self::$charset." COMMENT='Site Settings'",
				/* Daten für Tabelle settings */
				'insert' => "
						INSERT INTO ".TBL_PRFX."settings (var_id, slogan, firstname, lastname, street, postalzip, city, phone, email, company, opening, variable) VALUES
							(:var_id, :slogan, :firstname, :lastname, :street, :postalzip, :city, :phone, :email, :company, :opening, :variable)"
			),
			
			/* Tabellenstruktur für Tabelle site */
			'site' => array(
				/* Spalten Table site */
				'cols' => array('id', 'page', 'created', 'headline', 'content'),
				/* MySQL Query Table site */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."site (
						  id int(11) NOT NULL AUTO_INCREMENT,
						  page varchar(255) NOT NULL,
						  created date NOT NULL,
						  headline varchar(255) NOT NULL,
						  content text NOT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY page (page),
						  FULLTEXT KEY search (headline, content)
						) ENGINE=MyISAM  DEFAULT CHARSET=".self::$charset." COMMENT='Page Content'",
				/* Daten für Tabelle site */
				'insert' => "
						INSERT INTO ".TBL_PRFX."site (page, created, headline, content) VALUES (:page, :created, :headline, :content)"
			),
			
			/* Tabellenstruktur für Tabelle setup */
			'setup' => array(
				/* Spalten Table setup */
				'cols' => array('set_id', 'template', 'logout', 'maintenance', 'compress', 'maxwidth', 'maxheight'),
				/* MySQL Query Table setup */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."setup (
						  set_id int(11) NOT NULL,
						  template varchar(255) NOT NULL DEFAULT '".THEME_DEFAULT."',
						  logout tinyint(1) NOT NULL,
  						  maintenance tinyint(1) NOT NULL,
  						  compress tinyint(1) NOT NULL,
						  maxwidth int(4) unsigned NOT NULL,
						  maxheight int(4) unsigned NOT NULL,
						  PRIMARY KEY (set_id),
						  UNIQUE KEY id (set_id)
						) ENGINE=MyISAM DEFAULT CHARSET=".self::$charset." COMMENT='System Setup'",
				/* Daten für Tabelle site */
				'insert' => "
						INSERT INTO ".TBL_PRFX."setup (set_id, template, logout, maintenance, compress, maxwidth, maxheight) VALUES (:set_id, :template, :logout, :maintenance, :compress, :maxwidth, :maxheight)"
			),
			
			/* Tabellenstruktur für Tabelle panel */
			'panel' => array(
				/* Spalten Table panel */
				'cols' => array('number', 'last_modified', 'widget'),
				/* MySQL Query Table panel */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."panel (
						  _id int(11) NOT NULL AUTO_INCREMENT,
						  number varchar(255) NOT NULL,
  						  last_modified date NOT NULL,
  						  widget text NOT NULL,
						  PRIMARY KEY (_id)
						) ENGINE=MyISAM DEFAULT CHARSET=".self::$charset." COMMENT='Widget Area Content'",
				/* Daten für Tabelle site */
				'insert' => "
						INSERT INTO ".TBL_PRFX."panel (number, last_modified, widget) VALUES (:number, :last_modified, :widget)"
			),
			
			/* Tabellenstruktur für Tabelle user */
			'user' => array(
				/* Spalten Table user */
				'cols' => array('id', 'email', 'username', 'password', 'registration_date', 'code', 'status'),
				/* MySQL Query Table user */
				'create' => "
						CREATE TABLE IF NOT EXISTS ".TBL_PRFX."user (
						  id int(10) unsigned NOT NULL AUTO_INCREMENT,
						  email varchar(190) NOT NULL,
						  username varchar(17) NOT NULL,
						  password varchar(60) NOT NULL,
						  registration_date datetime NOT NULL,
						  code varchar(40) DEFAULT NULL,
						  status enum('admin','user') NOT NULL,
						  PRIMARY KEY (id),
						  UNIQUE KEY email (email,username)
						) ENGINE=MyISAM  DEFAULT CHARSET=".self::$charset." COMMENT='User Data'",
				/* Daten für Tabelle meta */
				'insert' => "
						INSERT INTO ".TBL_PRFX."user (email, username, password, registration_date, code, status) VALUES
							(:email, :username, :password, :registration_date, NULL, :status)"
			)
		);
		
		switch($select){
			
			case 'tables':
				foreach($dbStructure as $key => $value){
					$arrTables[] = $key;
				}
				break;
		
			case 'cols':
				foreach($dbStructure as $key => $value){
					$arrTables[$key] = $value['cols'];
				}
				break;
				
			case 'create':
				foreach($dbStructure as $key => $value){
					$arrTables[$key] = $value['create'];
				}
				break;
				
			case 'insert':
				foreach($dbStructure as $key => $value){
					$arrTables[$key] = $value['insert'];
				}
				break;
				
			default:
				$arrTables = $dbStructure;
				break;	
		}
		
		return $arrTables;
	}
}

?>