<?php

 /**
 * Validate Actions Controller
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
 * Class ValidationActionsController
 * @package Controller
 */

class ValidationActionsController {

	/** Properties */
	private $required_fields;
	private $fixed_part;
	private $panels;
	private $request;
	private $entries;

	/**
	 * Required fields Define entry pages
	 *
	 * @param array $required_fields
	 *
	 */

	public function setRequiredFields( $required_fields = [] ) {
		if( empty($required_fields) ){
			$this->required_fields = [
				'site' => [
					'title','page','headline','indexation'
				],
				'navigation' => [
					'anchor'
				],
				'user' => [
					'email','username','status'
				],
				'settings' => [
					'firstname','lastname','street','postalzip','city','phone','email','company','opening','variable'
				],
				'setup' => [
					'logout', 'maintenance', 'cache', 'maxwidth', 'maxheight'
				]
			];
		}
		else{
			$this->required_fields = $required_fields;
		}
	}

	/**
	 * Returns an array with required fields
	 *
	 * @param string $table
	 *
	 * @return mixed
	 */

	public function getRequiredFields( $table = '' ){
		// Fallback if empty var $this->required_fields
		if( empty($this->required_fields) ){
			$this->setRequiredFields();
		}
		if( !empty($this->required_fields[$table]) ){
			return $this->required_fields[$table];
		}
		return $this->required_fields;
	}


	/**
	 * Define fixed parts
	 *
	 * *Description* Define fixed system pages where only the content can be changed.
	 * They are not erasable and the page name can not be changed.
	 *
	 * @param array $fixed_part
	 */

	public function setFixedPart( $fixed_part = [] ) {
		if( !empty($fixed_part) ){
			$this->fixed_part = $fixed_part;
		}
		else{
			$this->fixed_part = [ 'index', 'imprint', 'contact', 'search', 'error' ];
		}
	}

	/**
	 * Returns an array with defined fixed system pages
	 *
	 * @return array
	 */

	public function getFixedPart(){
		if( empty($this->fixed_part) ){
			$this->setFixedPart();
		}
		return $this->fixed_part;
	}

	/**
	 * Specify possible panels for the entry
	 *
	 * @param array $panels
	 */

	public function setPanels( $panels = [] ) {
		$this->panels = [ 'panel1', 'panel2', 'panel3' ];
		if( !empty($panels) and is_array($panels) ){
			$this->panels = array_merge( $this->panels, $panels);
		}
	}

	/**
	 * Returns an array with allowed panels
	 *
	 * @return array
	 */

	public function getPanels(){
		if( empty($this->panels) ){
			$this->setPanels();
		}
		return $this->panels;
	}

	 /**
	  * Set a instance from Model GetContent
	  */

	 public function setEntriesData( $object = NULL ) {
		 if( is_object($object) ){
			 $this->entries = $object;
		 }
		 else{
			 $this->entries = new \Model\GetContent();
		 }

	 }

	 /**
	  * Returns a Model GetContent
	  *
	  * @return \Model\GetContent
	  */

	 public function getEntriesData() {
		 if ( ! $this->entries instanceof \Model\GetContent ) {
			 $this->setEntriesData();
		 }

		 return $this->entries;
	 }

	 /**
	  * Set data from request or params
	  *
	  * @param array $data
	  */

	 public function setRequestData( $data = [] ) {
		 if ( ! empty( $data ) and is_array( $data ) ) {
			 $this->request = $data;
		 } else {
			 $this->request = array_merge( \Controller\Helpers::Clean( $_GET ), $_POST );
		 }
	 }

	 /**
	  * Returns the data from request
	  *
	  * @param null $key
	  *
	  * @return mixed
	  */

	 public function getRequestData( $key = NULL ) {
		 if( isset($key) ){
			 return $this->request[$key];
		 }
		 return $this->request;
	 }

	 /**
	  * Validate form entry page
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return string
	  */

	public function validFormEntry($request){

		// Validate form pages
		$requiredSite = false;
		$requiredNav  = false;
		if(is_array($request)){
			// Check required fields
			foreach($this->getRequiredFields('site') as $key){
				if(!empty($request[$key])){
					$requiredSite = TRUE;
				}
				else{
					// Don't fill out required fields - then break
					$requiredSite = FALSE;
					break;
				}
			}
			// wenn Eintrag Menü gesetzt, dann ebenfalls Pflichtfelder prüfen
			if(!empty($request['menu-enable']) and $request['menu-enable'] == 'on'){
				foreach($this->getRequiredFields('navigation') as $key){
					if(!empty($request[$key])){
						$requiredNav = TRUE;
					}
					else{
						//Pflichtfeld nicht ausgefüllt - Abbruch
						$requiredNav = FALSE;
						break;
					}
				}
			}
			// wenn kein Menüeintrag ist keine Prüfung erforderlich
			else{
				$requiredNav = TRUE;
			}
			// sind alle Pflichtfelder ausgefüllt...
			if($requiredSite and $requiredNav){
				// Datenbankabfrage ob gesendete Page bereits existiert
				$entry = $this->getEntriesData()->getEntry( $this->getRequestData('page') );
				// Umwandeln in zugelassene Dateinmaen
				$request['page'] = \Controller\Helpers::buildLinkName($request['page']);
				// Prüfe ob eine ID mitgesendet wurde und diese auch mit der ID des Datensatz aus DB übereinstimmt
				if(
					!empty($request['id']) and $entry['id'] == $request['id'] and
					!$this->checkFixedPages($this->getRequestData('page'))
				){
					$request['page'] = $entry['page'];
				}
				// HTML Entities kodieren
				foreach($request as $key => $value){
					if(
						$key == 'title' or
					    $key == 'headline' or
					    $key == 'anchor' or
					    $key == 'description' or
					    $key == 'keywords'
					){
						if ( ! empty( $request[ $key ] ) ) {
							$request[ $key ] = htmlentities( strip_tags( trim( $value ) ), ENT_QUOTES, \Framework\Utility::getCharset() );
						} else {
							$request[ $key ] = '';
						}
					}
				}
			}
			else{
				return [];
			}
		}

		return $request;
	}

	 /**
	  * Check for unique page name
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function checkUniquePageName($name){

		//Prüfe auf bereits veregebene Seitennamen
		$arrnav = $this->getEntriesData()->getNavigation();
		$unique = FALSE;
		foreach($arrnav as $nav){
			if($nav['page'] == $name){
				$unique = FALSE;
				break;
			}
			else{
				$unique = TRUE;
			}
		}
		return $unique;
	}

	 /**
	  * Pruefe auf feste Systemseite
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function checkFixedPages($page){
		if(in_array($page, $this->getFixedPart())){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	 /**
	  * Pruefe moegliche Panel
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function validPanel($panel){
		if(in_array($panel['number'], $this->getPanels()) and isset($panel['widget'])){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	 /**
	  * Pruefe hochgeladene Bilder
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function checkUploadedImages($files){

        // fehlerbehandlung bilder
        $imagesize = false;
        $imagetyp = false;
		$whitelist = [ 'jpg','png','gif' ]; //zugelassene Dateiendungen

        if(is_array($files))
        {
            // maximale Dateigroesse Bilder ermitteln
            $max_size = \Controller\Helpers::maxSize(count($files));

			foreach($files as $value)
			{
				//Feststellen ob etwas zum Upload bereit steht
				if(!$value['error'])
				{
					//Endung der Bilddatei auslesen
					$path_parts = pathinfo($value['name']);
					//Vergleichen ob alles korrekt ist
					if(in_array($path_parts['extension'], $whitelist)){
						//Typ der Grafik als Konstante ermitteln
						//(wobei: IMAGETYPE_GIF = GIF, IMAGETYPE_JPEG = JPG, IMAGETYPE_PNG = PNG)
						$imgtype = exif_imagetype($value['tmp_name']);
						if($imgtype == IMAGETYPE_GIF or $imgtype == IMAGETYPE_JPEG or $imgtype == IMAGETYPE_PNG){
							$imagetyp = true;
						}
					}

					// Dateigroesse pruefen
					if($value['size'] < $max_size) {
						$imagesize = true;
					}
					if(!$imagesize or !$imagetyp){
						return false;
					}
				}
			}
			return true;
        }
	}

	 /**
	  * Pruefe einzigartigen Dateiname Bild
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function checkUniqueFilename($srcPath, $dstName){

		$unique = true;
		$path_parts = pathinfo($srcPath);
		$Filename = \Controller\Helpers::buildLinkName($dstName).'.'.$path_parts['extension'];
		// Hole alle Bilder und durchlaufe Test
		foreach ( $this->getEntriesData()->getAllImages() as $images ) {
			if($images['basename'] == $Filename){
				$unique = false;
				break;
			}
		}
		return $unique;
	}

	 /**
	  * Validiere Variablen
	  *
	  * *Description*
	  *
	  * @param array
	  *
	  * @return array
	  */

	public function validVarsSetting($request){

		$settings = $this->getEntriesData()->getSiteSettings();
		foreach($this->getRequiredFields('settings') as $key){
			if(!array_key_exists($key, $request)){
				$request[$key] = $settings[$key];
			}
		}
		// HTML Entities kodieren
		foreach($request as $key => $value){
			if($key != 'email'){
				if ( ! empty( $request[ $key ] ) ) {
					$request[ $key ] = htmlentities( strip_tags( $value ), ENT_QUOTES, \Framework\Utility::getCharset() );
				} else {
					$request[ $key ] = '';
				}
			}
		}
		return $request;
	}

	 /**
	  * Validiere Daten Setup
	  *
	  * *Description*
	  *
	  * @param array
	  *
	  * @return array
	  */

 	public function validSetup($request){
		$maxSize = 1260;
		$minSize = 180;
		// Formular Setup validieren
		if(is_array($request)) {
			foreach($this->getRequiredFields('setup') as $key){
				if(!array_key_exists($key, $request)){
					$request[$key] = 0;
				}
				else{
					if($key == 'maxwidth' or $key == 'maxheight'){
						$request[$key] = intval($request[$key], 10);
						if($request[$key] > $maxSize or $request[$key] < $minSize){
							$request = [];
							break;
						}
					}
				}
			}

			return $request;
		}
		else{
			return [];
		}
	}

	 /**
	  * Validiere Formular Benutzerverwaltung
	  *
	  * *Description*
	  *
	  * @param array
	  *
	  * @return boolean
	  */

	public function validFormUser( $request ){

		$required = FALSE;
		//Pflichtfelder User
		if(is_array($request)){
			foreach($this->getRequiredFields('user') as $key){
				if(!empty($request[$key])){
					$required = TRUE;
				}
				else{
					$required = FALSE;
					break;
				}
			}
			if(!empty($request['id'])){
				//Passwort prüfen bei Update User, aber nur bei Änderung
				if(!empty($request['password']) and $request['password'] !== $request['confirmpassword']){
					$required = FALSE;
				}
			}
			else{
				//Passwort prüfen wenn neuer User
				if(empty($request['password']) or $request['password'] !== $request['confirmpassword']){
					$required = FALSE;
				}
			}
		}

		return $required;
	}

	 /**
	  * Pruefe auf einzigartigen Benutzernamen
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function checkUniqueUsername($userName){
		// Prüfe auf einmaligen Nutzername
		$unique = TRUE;
		if ( ! empty( $this->getRequestData('user') ) and $userName != $this->getRequestData('user') ) {
			foreach ( $this->getEntriesData()->getAllUsers() as $user ) {
				if($user['username'] == $userName){
					$unique = FALSE;
					break;
				}
			}
		}
		return $unique;
	}

	 /**
	  * Pruefe auf letzen Administrator
	  *
	  * *Description* verhindert ein Loeschen des letzten Benutzer mit Administratorrechten
	  *
	  * @param
	  *
	  * @return boolean
	  */

	public function checkLastAdmin(){
		// Prüfe ob noch mindestens ein Administrator existiert
		$admin = 0;
		$setUser = $this->getRequestData('setUser');
		foreach ( $this->getEntriesData()->getAllUsers() as $user ) {
			if($user['status'] == 'admin'){
				++$admin;
			}
		}
		if($admin > 1 or ($admin >= 1 and !empty($setUser['status']) and $setUser['status'] == 'admin')){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

}

?>