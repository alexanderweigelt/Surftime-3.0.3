<?php
    
 /**
 * Library Model
 *
 * *Description* Pfade zu Bibliotheken und Systemerweiterungen laden
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 
 
class LibraryModel {
	
/**
 * Pfade der Bibliotheken aufrufen bzw. auslesen
 *
 * *Description* Pfad der gewählten Bibliothek checken und zurück geben.
 * 
 * @param string
 *
 * @return array
 */	
 	
	public function getLibrary($request){
		$path = array();
		if(is_dir(LIBS_PATH.$request.'/')){
			foreach(glob(LIBS_PATH.$request.'/*.{css,js}',GLOB_BRACE) as $file) {
				if(is_file($file)){
					$path[] = $file;
				}
			}
		}

		return $path;
	}
	
}

?>