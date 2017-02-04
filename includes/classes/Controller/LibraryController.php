<?php
    
 /**
 * Library Controller
 *
 * *Description* Aufrufe von Bibliotheken und Systemerweiterungen verarbeiten
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace Controller;


/**
 * Class LibraryController
 * @package Controller
 */

class LibraryController {
	
	/** Properties */
	public $get_libraries;

	/**
	 * LibraryController constructor.
	 */

	public function __construct() {
		$this->get_libraries = new \Model\LibraryModel();
	}

	/**
	 * Bibliotheken aufrufen
	 *
	 * *Description* Status der jeweiligen Bibliotheken an superglobale Varaible übergeben.
	 * Pfad der gewählten Bibliothek zurück geben.
	 *
	 * @param array | string
	 *
	 * @return array
	 */
	
	public function addLibrary($call = [] ){
		
		$path = '';
		
		/** Status in GLOBALS setzen */
		if(is_array($call)){
			$arr_libraries = $call;
		}
		else{
			$arr_libraries = [ $call ];
		}
		if(!empty($arr_libraries)){
			if ( \Controller\Helpers::getGlobals( 'Library' ) ) {
				$globArrLibrary = \Controller\Helpers::getGlobals( 'Library' );
			} else {
				$globArrLibrary = [];
			}
			if(
				!empty($globArrLibrary) and
			   is_array($globArrLibrary) and
			   !(in_array($arr_libraries, $globArrLibrary))
			){
				\Controller\Helpers::setGlobals('Library', array_merge($arr_libraries, $globArrLibrary));
			}
			elseif(!empty($globArrLibrary) and is_array($globArrLibrary)){
				\Controller\Helpers::setGlobals('Library', $globArrLibrary);
			}
			else{
				\Controller\Helpers::setGlobals('Library', $arr_libraries);
			}
			
			/** Pfad holen und zurück geben */
			foreach($arr_libraries as $lib){
				if(is_array($globArrLibrary) and !(in_array($lib, $globArrLibrary))){
					$arr_files = $this->get_libraries->getLibrary($lib);
					foreach($arr_files as $files){
						$path[] = $files;
					}
				}
			}
		}

		return $path;
	}
	
}

?>