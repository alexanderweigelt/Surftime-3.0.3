<?php
    
 /**
 * Actions Controller 
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class ActionsController extends \Controller\ValidationActionsController {
	
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
		parent::__construct();
	}
	
/**
 * Eintrag setzen
 *
 * *Description* Setzt einen neuen Einrag in die Datenbank
 * 
 * @param
 *
 * @return array 
 */
		
	public function setEntry(){
		
		$this->settings = new \Model\SetContent();
		$arrEntry = $this->validFormEntry($this->request['setEntry']);
		if(!empty($arrEntry)){
			if(LIMIT_PAGES >= count($this->entries->getEntries())){
				if($this->checkUniquePageName($arrEntry['page'])){
					if($this->settings->insertEntry($arrEntry)){
						//Erfolgsmeldung Eintrag
						$successInsert = array('error' => false, 'message' => '<strong>Congratulations:</strong> Entry is online');
					}
					else{
						//Fehlermeldung SQL fehlgeschlagen
						$successInsert = array('error' => true, 'message' => '<strong>Warning:</strong> Save failed');
					}
				}
				else{
					//Fehlermeldung Name bereits vergeben
					$successInsert = array('error' => true, 'message' => '<strong>Warning:</strong> Use unique URL');
				}
			}
			else{
				//Fehlermeldung Limit Einträge erreicht 
				$successInsert = array('error' => true, 'message' => '<strong>Warning:</strong> You have no authority to create more than '.LIMIT_PAGES.' pages');
			}
		}
		else{
			//Fehlermeldung Pflichtfelder
			$successInsert = array('error' => true, 'message' => '<strong>Warning:</strong> Fill out all required fields');
		}
		//
		return $successInsert;
	}
	
/**
 * Eintrag editieren
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function editEntry(){
		
		$this->settings = new \Model\SetContent();
		$arrEntry = $this->validFormEntry($this->request['setEntry']);
		if(!empty($arrEntry)){
			$uniqueName = ($arrEntry['page'] == $this->request['page']) ? TRUE : $this->checkUniquePageName($arrEntry['page']);
			if($uniqueName){
				if($this->settings->updateEntry($arrEntry)){
					//Erfolgsmeldung Eintrag
					$successEdit = array('error' => false, 'message' => '<strong>Congratulations:</strong> Entry is updated');
					if(!$this->checkFixedPages($arrEntry['page'])){ $successEdit['fixedPage'] = $arrEntry['page'];}
				}
				else{
					//Fehlermeldung SQL fehlgeschlagen
					$successEdit = array('error' => true, 'message' => '<strong>Warning:</strong> Edit failed');
				}
			}
			else{
				//Fehlermeldung Name bereits vergeben
				$successEdit = array('error' => true, 'message' => '<strong>Warning:</strong> Use unique URL');
			}
		}
		else{
			//Fehlermeldung Pflichtfelder
			$successEdit = array('error' => true, 'message' => '<strong>Warning:</strong> Fill out all required fields');
		}
		
		return $successEdit;	
	}
	
/**
 * Eintrag entfernen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function clearEntry(){
		
		$this->settings = new \Model\SetContent();
		if(!empty($this->request['page'])){
			if($this->checkFixedPages($this->request['page'])){
				if($this->settings->deleteEntry($this->request['page'])){
					//Erfolgsmeldung löschen
					$successDelete = array('error' => false, 'message' => '<strong>Congratulations:</strong> Entry is deleted');
				}
				else{
					//Fehlermeldung SQL fehlgeschlagen
					$successDelete = array('error' => true, 'message' => '<strong>Warning:</strong> Delete failed');
				}
			}
			else{
				//Fehlermeldung nicht löschbare Systemdatei
				$successDelete = array('error' => true, 'message' => '<strong>Warning:</strong> Undeletable system file');
			}
		}
		else{
			//Fehlermeldung fehlender Parameter
			$successDelete = array('error' => true, 'message' => '<strong>Warning:</strong> Missing parameter for delete');
		}
		return $successDelete;
	}
	
/**
 * Bild speichern
 *
 * *Description* 
 * 
 * @param
 *
 * @return array
 */
 
	public function saveImage(){
		
		$image = new \Model\ImageModel();
		$image->settings = $this->entries->getSetup();
		// Pfad des temp. Bild und neuen Dateiname aus Request
		$path_tmp = $this->request['tempimage'];
		$img_name = $this->request['filename'];
		if(!empty($path_tmp) and !empty($img_name)){
			if($this->checkUniqueFilename($path_tmp, $img_name)){
				//Erstelle das neue Bild
				$createImage = $image->createImage($path_tmp, $img_name);
				//Erstelle das Thumbnail
				$createThumbnail = $image->createImage($path_tmp, $img_name, 'thumb');
				// ist beides erfolgreich erstellt ...
				if($createImage and $createThumbnail){
					// Temporäres Bild löschen
					$image->removeImage($path_tmp);
					// Erfolgsmeldung
					$successSave = array('error' => false, 'message' => '<strong>Congratulations:</strong> Can use your image');
				}
				else{
					//Fehlermeldung
					$successSave = array('error' => true, 'message' => '<strong>Warning:</strong> Save failed');
				}
			}
			else{
				//Fehlermeldung
				$successSave = array('error' => true, 'message' => '<strong>Warning:</strong> Filename is already taken');
			}
		}
		else{
			//Fehlermeldung
			$successSave = array('error' => true, 'message' => '<strong>Warning:</strong> You must assign a Filename');
		}
		return $successSave;		
	}
	
/**
 * Bilder entfernen
 *
 * *Description* 
 * 
 * @param
 *
 * @return boolean
 */
 
	public function removeAllImages(){
		
		$remove = new \Model\ImageModel();
		$file = $this->request['path'];
		$unset_thumb = FALSE; 
		$unset_big = FALSE; 
		$unset_temp = FALSE;
		// normales Bild entfernen
		if(!empty($file) and file_exists(DIR_IMAGES_BIG.$file)){ 
			$remove->removeImage(DIR_IMAGES_BIG.$file);
			$unset_big = TRUE;
		}
		// Thumbnail entfernen
		if(!empty($file) and file_exists(DIR_IMAGES_THUMBNAILS.$file)){ 
			$remove->removeImage(DIR_IMAGES_THUMBNAILS.$file);
			$unset_thumb = TRUE;
		}
		// Temp. Bild entfernen
		if(!empty($file) and file_exists($file)){ 
			$remove->removeImage($file);
			$unset_temp = TRUE;
		}
		return ($unset_thumb and $unset_big or $unset_temp) ? TRUE : FALSE;
	}
	
/**
 * Bild hochladen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function uploadFile(){
		
		$uploadfile = new \Model\FileUpload(DIR_IMAGES_TEMP);
		$successUpload = $this->checkUploadedImages($_FILES) ? $uploadfile->upload($_FILES) : array('error' => true, 'message' => '<strong>Warning:</strong> File is not an image');
		
		return $successUpload;	
	}

	/**
	 * Variablen speichern
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return array
	 */

	public function saveSettings(){
		
		$this->settings = new \Model\SetContent();
		$request = $this->request['settings'];
		if(!empty($request)){
			if($this->settings->setSiteSettings($this->validVarsSetting($request))){
				//Erfolgsmeldung Eintrag gespeichert
				$successSetting = array('error' => false, 'message' => '<strong>Congratulations:</strong> stored change');
			}
			else{
				//Fehlermeldung Daten nicht gespeichert
				$successSetting = array('error' => true, 'message' => '<strong>Warning:</strong> Save failed');
			}
		}
		else{
			//Fehlermeldung keine Daten	
			$successSetting = array('error' => true, 'message' => '<strong>Warning:</strong> Missing Arguments');
		}
		return $successSetting;
	}
	
/**
 * Nutzerdaten speichern
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function setUserData(){
		
		$this->setuser = new \Model\SetContent();
		$request = $this->request['setUser'];
		// Prüfe auf Benutzerrechte zur Änderung bzw. zum neu anlegen
		if($this->entries->getRole() == 'admin' and count($this->entries->getAllUsers()) <= LIMIT_USER){
			// Formularvalidierung
			if($this->validFormUser($request)){
				//Check Username
				if(preg_match('/^[a-z0-9]{5,}$/i', $request['username'])){
					// nachschauen, ob Nutzername schon existiert
					if($this->checkUniqueUsername($request['username'])){
						if(\Controller\Helpers::checkEmail($request['email'])){
							if(!empty($request['id']) and is_numeric($request['id'])){
								// bei erfolgreicher Prüfung entweder Setup oder Edit User
								if($this->checkLastAdmin()){
									if($this->setuser->updateUser($request)){
										$successSetUser = array('error' => false, 'message' => '<strong>Congratulations:</strong> User is active');
									}
									else{
										$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> Save failed');
									}
								}
								else{
									$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> Refused action, you need at least an admin');
								}
							}
							else{
								if($this->setuser->setNewUser($request)){
									$successSetUser = array('error' => false, 'message' => '<strong>Congratulations:</strong> New User is active');
								}
								else{
									$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> Save failed');
								}
							}
						}
						else{
							$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> Check e-mail address');
						}
					}
					else{
						//Fehlermeldung Username schon vergeben
						$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> The username is already taken');
					}
				}
				else{
					//Fehlermeldung Username zu kurz
					$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong> Username must be at least. 5 characters (letters and numbers)');
				}	
			}
			else{
				//Fehlermeldung Pflichtfelder ausfüllen
				$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong>  Fill out all required fields');
			}
		}
		else{
			//Fehlermeldung fehlende Nutzerrechte
			$successSetUser = array('error' => true, 'message' => '<strong>Warning:</strong>  Action not allowed');
		}
		return $successSetUser;
	}
	
/**
 * Nutzer entfernen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function removeThisUser(){
		
		$this->setuser = new \Model\SetContent();
		$userData = $this->entries->getUserData($this->request['username']);
		$lastAdmin =  $userData['status'] == 'user' ? TRUE : $this->checkLastAdmin();
		if(!empty($this->request['username']) and $this->entries->getRole() == 'admin' and $lastAdmin){
			if($this->setuser->deleteUser($this->request['username'])){
				//Erfolgsmeldung Eintrag gespeichert
				$successRemoveUser = array('error' => false, 'message' => '<strong>Congratulations:</strong> User removed');
			}
			else{
				$successRemoveUser = array('error' => true, 'message' => '<strong>Warning:</strong>  Action not allowed');
			}
		}
		else{
			//Fehlermeldung fehlende ID und Benutzerrechte
			$successRemoveUser = array('error' => true, 'message' => '<strong>Warning:</strong>  Missing User rights');
		}
		return $successRemoveUser;
	}
	
/**
 * Layout speichern
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function chooseTheme(){
	
		$this->setTPL = new \Model\SetContent();
		$tpl['template'] = \Controller\Helpers::Clean($this->request['theme']['select']);
		if($this->entries->getRole() == 'admin'){
			if(!empty($tpl['template'])){		
				if($this->setTPL->setSetup($tpl, 'template')){
					$successChooseTheme = array('error' => false, 'message' => '<strong>Congratulations:</strong>  Updated Template');
				}
				else{
					$successChooseTheme = array('error' => true, 'message' => '<strong>Warning:</strong>  Save failed');
				}
			}
			else{
				$successChooseTheme = array('error' => true, 'message' => '<strong>Warning:</strong> Choose a Template');
			}
		}
		else{
			$successChooseTheme = array('error' => true, 'message' => '<strong>Warning:</strong>  Missing User rights');
		}
		return $successChooseTheme;
	}

/**
 * Inhalt Panel aktualisieren
 *
 * *Description* Veranlasst eine Validierung des übergebenen Inhalt. Danach startet der Update in Datenbank für jeweiliges Panel.
 * 
 * @param
 *
 * @return array 
 */	
	
	public function updatePanel(){
		
		$this->setSidebar = new \Model\SetContent();
		$requestPanel = $this->request['updatePanel'];
		if($this->validPanel($requestPanel)){
			if($this->setSidebar->setPanel($requestPanel)){
				$successUpdatePanel = array('error' => false, 'message' => '<strong>Congratulations:</strong>  Updated Panel');
			}
			else{
				$successUpdatePanel = array('error' => true, 'message' => '<strong>Warning:</strong>  Save failed');
			}
		}
		else{
			// Fehlermeldung Panel nicht vorhanden
			$successUpdatePanel = array('error' => true, 'message' => '<strong>Warning:</strong>  Incorrect Data');
		}
		return $successUpdatePanel;
	}

/**
 * Systemeinstellungen setzen
 *
 * *Description* Veranlasst eine Validierung des übergebenen Inhalt. Danach werden die Einstellungen in der DB gespeichert.
 * 
 * @param
 *
 * @return array 
 */
 
 	public function Setup(){
		
		$this->setup = new \Model\SetContent();
		$requestSetup = $this->request['setup'];
		if($this->entries->getRole() == 'admin'){
			$setup = $this->validSetup($requestSetup);
			if(!empty($setup)){
				if($this->setup->setSetup($setup, 'system')){
					$successSetup = array('error' => false, 'message' => '<strong>Congratulations:</strong>  Success save Setup');
				}
				else{
					$successSetup = array('error' => true, 'message' => '<strong>Warning:</strong>  Save failed');
				}
			}
			else{
				//Fehlermeldung Pflichtfelder
				$successSetup = array('error' => true, 'message' => '<strong>Warning:</strong> Bad values to set up');
			}
		}
		else{
			$successSetup = array('error' => true, 'message' => '<strong>Warning:</strong>  Missing User rights');
		}
		//
		return $successSetup;
	}
}

?>