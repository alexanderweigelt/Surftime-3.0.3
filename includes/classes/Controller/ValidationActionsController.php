<?php

 /**
 * Validate Actions Controller
 *
  * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
  */

 namespace Controller;


 /**
  * Class ValidationActionsController
  * @package Controller
  */
 class ValidationActionsController {

	/** Eigenschaften definieren */
	 private $required_fields = [];
	 private $fixed_part = [];
	 private $panels = [];
	public $request;
	public $entries;

	 /**
	  * Constructor
	  *
	  * *Description*
	  */

	public function __construct() {
		//Pflichtfelder Eintrag Seiten definieren
		$this->required_fields = array(
			'site' => array('title','page','headline','indexation'),
			'navigation' => array('anchor'),
			'user' => array('email','username','status'),
			'settings' => array('firstname','lastname','street','postalzip','city','phone','email','company','opening','variable'),
			'setup' => array('logout', 'maintenance', 'cache', 'maxwidth', 'maxheight')
		);

		// Fixe Systemseiten definieren, bei denen nur der Inhalt geändert werden kann.
		// Sie sind nicht löschbar und auch der Pagename kann nicht geändert werden.
		$this->fixed_part = array('index', 'imprint', 'contact', 'search', 'error');

		// Lege mögliche Panel für den Eintrag fest
		$this->panels = array('panel1', 'panel2', 'panel3');
	}

	 /**
	  * Set a instance from Model GetContent
	  */

	 public function setEntriesData() {
		 $this->entries = new \Model\GetContent();
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
	  * @return mixed
	  */

	 public function getRequestData() {
		 return $this->request;
	 }

	 /**
	  * Formular Eintrag Seite validieren
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return string
	  */

	public function validFormEntry($request){

		// Formular Pages validieren
		$requiredSite = false;
		$requiredNav  = false;
		if(is_array($request)){
			//Pflichtfelder prüfen
			foreach($this->required_fields['site'] as $key){
				if(!empty($request[$key])){
					$requiredSite = TRUE;
				}
				else{
					//Pflichtfeld nicht ausgefüllt - Abbruch
					$requiredSite = FALSE;
					break;
				}
			}
			// wenn Eintrag Menü gesetzt, dann ebenfalls Pflichtfelder prüfen
			if(!empty($request['menu-enable']) and $request['menu-enable'] == 'on'){
				foreach($this->required_fields['navigation'] as $key){
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
				$entry = $this->getEntriesData()->getEntry( $this->request['page'] );
				// Umwandeln in zugelassene Dateinmaen
				$request['page'] = \Controller\Helpers::buildLinkName($request['page']);
				// Prüfe ob eine ID mitgesendet wurde und diese auch mit der ID des Datensatz aus DB übereinstimmt
				if(!empty($request['id']) and $entry['id'] == $request['id'] and !$this->checkFixedPages($this->request['page'])){
					$request['page'] = $entry['page'];
				}
				// HTML Entities kodieren
				foreach($request as $key => $value){
					if($key == 'title' or $key == 'headline' or $key == 'anchor' or $key == 'description' or $key == 'keywords'){
						$request[ $key ] = ! empty( $request[ $key ] ) ? htmlentities( strip_tags( trim( $value ) ), ENT_QUOTES, \Framework\Utility::getCharset() ) : '';
					}
				}
			}
			else{
				return array();
			}
		}

		return $request;
	}

	 /**
	  * Pruefe auf einzigartigen Page-Name
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
		if(in_array($page, $this->fixed_part)){
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
		if(in_array($panel['number'], $this->panels) and isset($panel['widget'])){
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
		$whitelist = array('jpg','png','gif'); //zugelassene Dateiendungen

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
		foreach($this->required_fields['settings'] as $key){
			if(!array_key_exists($key, $request)){
				$request[$key] = $settings[$key];
			}
		}
		// HTML Entities kodieren
		foreach($request as $key => $value){
			if($key != 'email'){
				$request[$key] = !empty($request[$key]) ? htmlentities(strip_tags($value), ENT_QUOTES, \Framework\Utility::getCharset()) : '';
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
			foreach($this->required_fields['setup'] as $key){
				if(!array_key_exists($key, $request)){
					$request[$key] = 0;
				}
				else{
					if($key == 'maxwidth' or $key == 'maxheight'){
						$request[$key] = intval($request[$key], 10);
						if($request[$key] > $maxSize or $request[$key] < $minSize){
							$request = array();
							break;
						}
					}
				}
			}

			return $request;
		}
		else{
			return array();
		}
	}

	 /**
	  * Validiere Formular Benutzerverwaltung
	  *
	  * *Description*
	  *
	  * @param string
	  *
	  * @return boolean
	  */

	public function validFormUser($request){

		//Pflichtfelder User
		if(is_array($request)){
			foreach($this->required_fields['user'] as $key){
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
		if ( ! empty( $this->request['user'] ) and $userName != $this->request['user'] ) {
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
		foreach ( $this->getEntriesData()->getAllUsers() as $user ) {
			if($user['status'] == 'admin'){
				++$admin;
			}
		}
		if($admin > 1 or ($admin >= 1 and !empty($this->request['setUser']['status']) and $this->request['setUser']['status'] == 'admin')){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}

?>