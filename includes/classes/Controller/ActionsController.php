<?php
    
 /**
 * Actions Controller 
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
 * Class ActionsController
 * @property \Model\SetContent settings
 * @property \Model\SetContent setuser
 * @property \Model\SetContent setTPL
 * @property \Model\SetContent setSidebar
 * @property \Model\SetContent setup
 * @package Controller
 */

class ActionsController extends \Controller\ValidationActionsController {

	/**
	 * Set entry
	 *
	 * *Description* Writes a new page to database
	 *
	 * @param
	 *
	 * @return array
	 */
		
	public function setEntry(){
		
		$this->settings = new \Model\SetContent();
		$this->setRequiredFields();
		$arrEntry = $this->validFormEntry($this->getRequestData('setEntry'));
		if(!empty($arrEntry)){
			if ( LIMIT_PAGES >= count( $this->getEntriesData()->getEntries() ) ) {
				if($this->checkUniquePageName($arrEntry['page'])){
					if($this->settings->insertEntry($arrEntry)){
						//Erfolgsmeldung Eintrag
						$successInsert = [
							'error' => false,
							'message' => '<strong>Congratulations:</strong> Entry is online'
						];
					}
					else{
						//Fehlermeldung SQL fehlgeschlagen
						$successInsert = [
							'error' => true,
							'message' => '<strong>Warning:</strong> Save failed'
						];
					}
				}
				else{
					//Fehlermeldung Name bereits vergeben
					$successInsert = [
						'error' => true,
						'message' => '<strong>Warning:</strong> Use unique URL'
					];
				}
			}
			else{
				//Fehlermeldung Limit Einträge erreicht
				$successInsert = [
					'error' => true,
					'message' => '<strong>Warning:</strong> You have no authority to create more than pages as ' . LIMIT_PAGES
				];
			}
		}
		else{
			//Fehlermeldung Pflichtfelder
			$successInsert = [
				'error' => true,
				'message' => '<strong>Warning:</strong> Fill out all required fields'
			];
		}
		//
		return $successInsert;
	}

	/**
	 * Edit entry
	 *
	 * *Description* Edit a page entry on database
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function editEntry(){
		
		$this->settings = new \Model\SetContent();
		$arrEntry = $this->validFormEntry($this->getRequestData('setEntry'));
		if(!empty($arrEntry)){
			if ( ( $arrEntry['page'] == $this->getRequestData('page') ) ) {
				$uniqueName = true;
			} else {
				$uniqueName = $this->checkUniquePageName( $arrEntry['page'] );
			}
			if($uniqueName){
				if($this->settings->updateEntry($arrEntry)){
					//Erfolgsmeldung Eintrag
					$successEdit = [
						'error' => false,
						'message' => '<strong>Congratulations:</strong> Entry is updated'
					];
					if( !$this->checkFixedPages($arrEntry['page']) ){
						$successEdit['fixedPage'] = $arrEntry['page'];
					}
				}
				else{
					//Fehlermeldung SQL fehlgeschlagen
					$successEdit = [
						'error' => true,
						'message' => '<strong>Warning:</strong> Edit failed'
					];
				}
			}
			else{
				//Fehlermeldung Name bereits vergeben
				$successEdit = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Use unique URL'
				];
			}
		}
		else{
			//Fehlermeldung Pflichtfelder
			$successEdit = [
				'error' => true,
				'message' => '<strong>Warning:</strong> Fill out all required fields'
			];
		}
		
		return $successEdit;	
	}

	/**
	 * Delete entry
	 *
	 * *Description* Delete an entry page from database
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function clearEntry(){
		
		$this->settings = new \Model\SetContent();
		if(!empty($this->getRequestData('page'))){
			if($this->checkFixedPages($this->getRequestData('page'))){
				if($this->settings->deleteEntry($this->getRequestData('page'))){
					//Erfolgsmeldung löschen
					$successDelete = [
						'error' => false,
						'message' => '<strong>Congratulations:</strong> Entry is deleted'
					];
				}
				else{
					//Fehlermeldung SQL fehlgeschlagen
					$successDelete = [
						'error' => true,
						'message' => '<strong>Warning:</strong> Delete failed'
					];
				}
			}
			else{
				//Fehlermeldung nicht löschbare Systemdatei
				$successDelete = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Undeletable system file'
				];
			}
		}
		else{
			//Fehlermeldung fehlender Parameter
			$successDelete = [
				'error' => true,
				'message' => '<strong>Warning:</strong> Missing parameter for delete'
			];
		}
		return $successDelete;
	}

	/**
	 * Save Image
	 *
	 * *Description* Saves Images on file system
	 *
	 * @param
	 *
	 * @return array
	 */

	public function saveImage(){
		
		$image = new \Model\ImageModel();
		$image->settings = $this->getEntriesData()->getSetup();
		// Pfad des temp. Bild und neuen Dateiname aus Request
		$path_tmp = $this->getRequestData('tempimage');
		$img_name = $this->getRequestData('filename');
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
					$successSave = [
						'error' => false,
						'message' => '<strong>Congratulations:</strong> Can use your image'
					];
				}
				else{
					//Fehlermeldung
					$successSave = [
						'error' => true,
						'message' => '<strong>Warning:</strong> Save failed'
					];
				}
			}
			else{
				//Fehlermeldung
				$successSave = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Filename is already taken'
				];
			}
		}
		else{
			//Fehlermeldung
			$successSave = [
				'error' => true,
				'message' => '<strong>Warning:</strong> You must assign a Filename'
			];
		}
		return $successSave;		
	}

	/**
	 * Remove Images
	 *
	 * *Description* Remove Images from file system
	 *
	 * @param
	 *
	 * @return boolean
	 */
 
	public function removeAllImages(){
		
		$remove = new \Model\ImageModel();
		$file = $this->getRequestData('path');
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
	 * File upload
	 *
	 * *Description* Uploads images to file system
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function uploadFile(){
		
		$uploadfile = new \Model\FileUpload(DIR_IMAGES_TEMP);
		if ( $this->checkUploadedImages( $_FILES ) ) {
			$successUpload = $uploadfile->upload( $_FILES );
		} else {
			$successUpload = [
				'error' => true,
				'message' => '<strong>Warning:</strong> File is not an image'
			];
		}
		
		return $successUpload;	
	}

	/**
	 * Save vars
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return array
	 */

	public function saveSettings(){
		
		$this->settings = new \Model\SetContent();
		$request = $this->getRequestData('settings');
		if(!empty($request)){
			if($this->settings->setSiteSettings($this->validVarsSetting($request))){
				//Erfolgsmeldung Eintrag gespeichert
				$successSetting = [
					'error' => false,
					'message' => '<strong>Congratulations:</strong> stored change'
				];
			}
			else{
				//Fehlermeldung Daten nicht gespeichert
				$successSetting = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Save failed'
				];
			}
		}
		else{
			//Fehlermeldung keine Daten	
			$successSetting = [
				'error' => true,
				'message' => '<strong>Warning:</strong> Missing Arguments'
			];
		}
		return $successSetting;
	}

	/**
	 * Save User data
	 *
	 * *Description* Write user data to database
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function setUserData(){
		
		$this->setuser = new \Model\SetContent();
		$request = $this->getRequestData('setUser');
		// Prüfe auf Benutzerrechte zur Änderung bzw. zum neu anlegen
		if (
			$this->getEntriesData()->getRole() == 'admin' and
			count( $this->getEntriesData()->getAllUsers() ) <= LIMIT_USER
		) {
			// Valid form
			if($this->validFormUser($request)){
				// Check Username
				if(preg_match('/^[a-z0-9]{5,}$/i', $request['username'])){
					// nachschauen, ob Nutzername schon existiert
					if($this->checkUniqueUsername($request['username'])){
						if(\Controller\Helpers::checkEmail($request['email'])){
							if(!empty($request['id']) and is_numeric($request['id'])){
								// bei erfolgreicher Prüfung entweder Setup oder Edit User
								if($this->checkLastAdmin()){
									if($this->setuser->updateUser($request)){
										$successSetUser = [
											'error' => false,
											'message' => '<strong>Congratulations:</strong> User is active'
										];
									}
									else{
										$successSetUser = [
											'error' => true,
											'message' => '<strong>Warning:</strong> Save failed'
										];
									}
								}
								else{
									$successSetUser = [
										'error' => true,
										'message' => '<strong>Warning:</strong> Refused action, you need at least an admin'
									];
								}
							}
							else{
								if($this->setuser->setNewUser($request)){
									$successSetUser = [
										'error' => false,
										'message' => '<strong>Congratulations:</strong> New User is active'
									];
								}
								else{
									$successSetUser = [
										'error' => true,
										'message' => '<strong>Warning:</strong> Save failed'
									];
								}
							}
						}
						else{
							$successSetUser = [
								'error' => true,
								'message' => '<strong>Warning:</strong> Check e-mail address'
							];
						}
					}
					else{
						//Fehlermeldung Username schon vergeben
						$successSetUser = [
							'error' => true,
							'message' => '<strong>Warning:</strong> The username is already taken'
						];
					}
				}
				else{
					//Fehlermeldung Username zu kurz
					$successSetUser = [
						'error' => true,
						'message' => '<strong>Warning:</strong> Username must be at least. 5 characters (letters and numbers)'
					];
				}	
			}
			else{
				//Fehlermeldung Pflichtfelder ausfüllen
				$successSetUser = [
					'error' => true,
					'message' => '<strong>Warning:</strong>  Fill out all required fields'
				];
			}
		}
		else{
			//Fehlermeldung fehlende Nutzerrechte
			$successSetUser = [
				'error' => true,
				'message' => '<strong>Warning:</strong>  Action not allowed'
			];
		}
		return $successSetUser;
	}

	/**
	 * Delete user
	 *
	 * *Description* Delete a user entry from database
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function removeThisUser(){
		
		$this->setuser = new \Model\SetContent();
		$userData = $this->getEntriesData()->getUserData( $this->getRequestData('username') );
		$lastAdmin = $userData['status'] == 'user' ? TRUE : $this->checkLastAdmin();
		if (
			! empty( $this->getRequestData('username') ) and
			$this->getEntriesData()->getRole() == 'admin' and
			$lastAdmin
		) {
			if($this->setuser->deleteUser($this->getRequestData('username'))){
				//Erfolgsmeldung Eintrag gespeichert
				$successRemoveUser = [
					'error' => false,
					'message' => '<strong>Congratulations:</strong> User removed'
				];
			}
			else{
				$successRemoveUser = [
					'error' => true,
					'message' => '<strong>Warning:</strong>  Action not allowed'
				];
			}
		}
		else{
			//Fehlermeldung fehlende ID und Benutzerrechte
			$successRemoveUser = [
				'error' => true,
				'message' => '<strong>Warning:</strong>  Missing User rights'
			];
		}
		return $successRemoveUser;
	}

	/**
	 * Save layout
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return array
	 */
 
	public function chooseTheme(){
	
		$this->setTPL = new \Model\SetContent();
		$requestTheme = $this->getRequestData('theme');
		$tpl['template'] = \Controller\Helpers::Clean($requestTheme['select']);
		if ( $this->getEntriesData()->getRole() == 'admin' ) {
			if(!empty($tpl['template'])){		
				if($this->setTPL->setSetup($tpl, 'template')){
					$successChooseTheme = [
						'error' => false,
						'message' => '<strong>Congratulations:</strong>  Updated Template'
					];
				}
				else{
					$successChooseTheme = [
						'error' => true,
						'message' => '<strong>Warning:</strong>  Save failed'
					];
				}
			}
			else{
				$successChooseTheme = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Choose a Template'
				];
			}
		}
		else{
			$successChooseTheme = [
				'error' => true,
				'message' => '<strong>Warning:</strong>  Missing User rights'
			];
		}
		return $successChooseTheme;
	}

	/**
	 * Update content panel
	 *
	 * *Description* Causes a validation of the passed content. After that,
	 * the update will start in the database for each panel.
	 *
	 * @param
	 *
	 * @return array
	 */
	
	public function updatePanel(){
		
		$this->setSidebar = new \Model\SetContent();
		$requestPanel = $this->getRequestData('updatePanel');
		if($this->validPanel($requestPanel)){
			if($this->setSidebar->setPanel($requestPanel)){
				$successUpdatePanel = [
					'error' => false,
					'message' => '<strong>Congratulations:</strong>  Updated Panel'
				];
			}
			else{
				$successUpdatePanel = [
					'error' => true,
					'message' => '<strong>Warning:</strong>  Save failed'
				];
			}
		}
		else{
			// Fehlermeldung Panel nicht vorhanden
			$successUpdatePanel = [
				'error' => true,
				'message' => '<strong>Warning:</strong>  Incorrect Data'
			];
		}
		return $successUpdatePanel;
	}

	/**
	 * System settings
	 *
	 * *Description* Causes a validation of the passed content. Then the settings are stored in the DB.
	 *
	 * @param
	 *
	 * @return array
	 */
 
 	public function Setup(){
		
		$this->setup = new \Model\SetContent();
		$requestSetup = $this->getRequestData('setup');
	    if ( $this->getEntriesData()->getRole() == 'admin' ) {
			$setup = $this->validSetup($requestSetup);
			if(!empty($setup)){
				if($this->setup->setSetup($setup, 'system')){
					$successSetup = [
						'error' => false,
						'message' => '<strong>Congratulations:</strong>  Success save Setup'
					];
				}
				else{
					$successSetup = [
						'error' => true,
						'message' => '<strong>Warning:</strong>  Save failed'
					];
				}
			}
			else{
				//Fehlermeldung Pflichtfelder
				$successSetup = [
					'error' => true,
					'message' => '<strong>Warning:</strong> Bad values to set up'
				];
			}
		}
		else{
			$successSetup = [
				'error' => true,
				'message' => '<strong>Warning:</strong>  Missing User rights'
			];
		}

	    return $successSetup;
	}
}

?>