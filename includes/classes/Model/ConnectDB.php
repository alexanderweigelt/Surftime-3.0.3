<?php
    
 /**
 * Connect Database Model
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
 * Class ConnectDB
 * @package Model
 */

class ConnectDB {
	
	/** Properties */
	public static $charset;
	
	/**
	 * Connect database
	 *
	 * *Description* Methode ohne instanziieren der Klasse aufrufen
	 *
	 * @param
	 *
	 * @return object
	 */
 
 	public static function connect(){
		
		self::setMySQLCharset();

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
	 * Set database charset
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
	 * Set mysql port
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
	 * Set database structure
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

			/* structure for table meta */
			'meta' => array(
				/* Spalten Table meta */
				'cols' => array( '_id', 'page_id', 'indexation', 'title', 'keywords', 'description' )
			),

			/* structure for table navigation */
			'navigation' => array(
				/* Spalten Table navigation */
				'cols' => array( '_id', 'site_id', 'sorting', 'parent', 'anchor' )
			),

			/* structure for table settings */
			'settings' => array(
				/* Spalten Table settings */
				'cols' => array(
					'var_id',
					'slogan',
					'firstname',
					'lastname',
					'street',
					'postalzip',
					'city',
					'phone',
					'email',
					'company',
					'opening',
					'variable'
				)
			),

			/* structure for table site */
			'site' => array(
				/* Spalten Table site */
				'cols' => array('id', 'page', 'created', 'headline', 'content'),
			),

			/* structure for table setup */
			'setup' => array(
				/* Spalten Table setup */
				'cols' => array(
					'set_id',
					'template',
					'logout',
					'maintenance',
					'compress',
					'language',
					'maxwidth',
					'maxheight'
				)
			),

			/* structure for table panel */
			'panel' => array(
				/* Spalten Table panel */
				'cols' => array( '_id', 'number', 'last_modified', 'widget' )
			),

			/* structure for table user */
			'user' => array(
				/* Spalten Table user */
				'cols' => array( 'id', 'email', 'username', 'password', 'registration_date', 'code', 'status' )
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
				
			default:
				$arrTables = $dbStructure;
				break;	
		}
		
		return $arrTables;
	}
}

?>