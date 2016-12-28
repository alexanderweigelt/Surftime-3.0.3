<?php
    
 /**
 * Admin Controller
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
  * Class AdminController
  * @package Controller
  */

 class AdminController {
	
	/** Eigenschaft definieren */
    public $login;
	public $entries;
	public $success = [];
	
/**
 * Constructor
 *
 * *Description*
 */
 
    public function __construct() {	
		
		$this->request = array_merge(\Controller\Helpers::Clean($_GET), $_POST);
		$this->response = new \Framework\Response();
		$this->response->errorReporting();
		$this->login = new \Controller\LoginController();
		$this->view = new \View\Admin();
		$this->entries = new \Model\GetContent();
		$this->libs = new \View\Library();
		
		// Wenn Datenbank noch nicht installiert weiter leiten an Installseite
		$this->checkInstall();
		
		//MIME Typ festlegen
		$this->sendAllHeaders();
	}
	
/**
 * Ausgaben im Backend erzeugen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function display() {

		// Handle Login
		$this->login->SetLogin();

		// Load action Models and Controllers
		if(isset($this->request['action']) and $this->login->CheckLogin()){
			$action = new \Controller\ActionsController();
			$action->setRequestData( $this->request );
			$action->entries = $this->entries;
			
			switch ($this->request['action']) {
				
				case 'insert':
					// Insert Entry
					$this->success['Entry'] = $action->setEntry();
					break;
			
				case 'edit':
					// Edit Entry
					$this->success['Entry'] = $action->editEntry();
					break;
					
				case 'delete':
					// Delete Entry
					$this->success['Entry'] = $action->clearEntry();
					break;
				
				case 'upload':
					// Upload File
					$this->success['Upload'] = $action->uploadFile();
					break;
					
				case 'save':
					// Save Image
					$this->success['Save'] = $action->saveImage();
					break;
					
				case 'remove':
					// Remove Image
					$action->removeAllImages();
					break;
					
				case 'update':
					// Update Panel
					$this->success['Panel'] = $action->updatePanel();
					break;
					
				case 'settings':
					// Website Settings
					$this->success['Settings'] = $action->saveSettings();
					break;
					
				case 'setup':
					// Website Settings
					$this->success['Setup'] = $action->Setup();
					break;
					
				case 'setuser':
					// User edit
					$this->success['User'] = $action->setUserData();
					break;
					
				case 'deleteuser':
					// Delete User
					$this->success['User'] = $action->removeThisUser();
					break; 
					
				case 'choose':
					// Choose Theme
					$this->success['Template'] = $action->chooseTheme();
					break;
					
				case 'logout':
					// Logout
					$this->login->Logout();
					break;
								
			}
		}

		//Load content start here
		define('DIR_PROTECTION',TRUE);	
		
		if($this->login->CheckLogin()){
			$p = isset($this->request['load']) ? $this->request['load'] : 'start';
			//Whitelist Param load
        	$this->view->siteContent = file_exists(DIR_ADMIN.'pages/'.$p.'.php') ? DIR_ADMIN.'pages/'.$p.'.php' : DIR_ADMIN.'pages/error.php';
			
			switch($p) {
				
				case 'start':
					//Data Startsite
					$this->view->Data = $this->DataStart();
					break;
					
				case 'page':
					//Data Edit Page
					$editPage = isset($this->request['page']) ? $this->request['page'] : '';
					$this->view->Data = $this->DataPage($editPage);
					break;
			
				case 'setting':
					//Data Site Settings
					$this->view->Data = $this->DataSettings();
					break;
					
				case 'user':
					//Data Edit User 
					$editUser = isset($this->request['user']) ? $this->request['user'] : '';
					$this->view->Data = $this->DataUsers($editUser);
					break;
				
				case 'plugin':
					//Data Edit User 
					$editPlugin = isset($this->request['plugin']) ? $this->request['plugin'] : '';
					$this->view->Data = $this->DataPlugin($editPlugin);
					break;	
					
				case 'panel':
					//Data Edit Panel
					$editPanel = isset($this->request['panel']) ? $this->request['panel'] : '';
					$this->view->Data = $this->DataPanel($editPanel);
					break;	
			}
		}
		else{
			$this->view->classFormLogin = $this->login->loginData['classFormLogin'];
			$this->view->siteContent = DIR_ADMIN.'pages/login.php';
		}
		// Load System Infos
		$this->view->SystemInfo = $this->entries->readSystemInfos();
		// Load Library
		$this->view->Library = $this->libs;

        try {
            return $this->view->parse();
        } catch (\Framework\Exception $e) {
            return $e->getMessage();
        }
		
	}
	
/**
 * Daten Ausgabe Startseite erzeugen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function DataStart(){
		$data = [];
		//Split Entries for pagination
		$num = (isset($this->request['num']) and is_numeric($this->request['num'])) ? (int)$this->request['num'] : 0;
		$limit = 10;
		
		$data['Entries'] = \Controller\Helpers::paganation($this->entries->getEntries(), $num, $limit);
		$data['Pager']['pageNumber'] = $num;
		$data['Pager']['countEntries'] = count($this->entries->getEntries());
		$data['Pager']['limitEntries'] = $limit;
		$data['AllImages'] = $this->entries->getAllImages();
		foreach($this->entries->getPanel() as $note){
			$data['Sidebar'][$note['number']] = $note['last_modified'];
		}
		$data['Success'] = $this->success;
		if(!empty($data['Success']['Upload']) or !empty($data['Success']['Save'])){
			$data['Tab'] = $this->TabControl(3);
		}
		else{
			$data['Tab'] = $this->TabControl(2);
		}
		foreach(glob(DIR_PLUGIN.'*') as $file){ 
			$dir = explode("/", $file);
			$plugin = array_pop($dir);
			$data['Plugins'][$plugin] = DIR.'?load=plugin&amp;plugin='.$plugin; 
		}
		
		return $data;
	}
	
/**
 * Daten Ausgabe Seitenbearbeitung erzeugen
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	public function DataPage($page = ''){
		// Lade Inhalt Single Page
		$data = array();
		$data['Action'] = DIR.'?load=page&amp;action=insert';
		// im GET-Parameter ist die Page enthalten
		if(!empty($page)){
			// ActionController gibt einen Error zurück
			if(!empty($this->success['Entry']) and $this->success['Entry']['error']){
				$data['Entry'] = $this->request['setEntry'];
			}
			// ActionController meldet Eintrag erfolgreich
			else{
				// wurde der Dateiname geändert, lese Inhalte für diesen
				if(!empty($this->request['setEntry']['page']) and $page != $this->request['setEntry']['page']){
					$p = isset($this->success['Entry']['fixedPage']) ? $this->success['Entry']['fixedPage'] : $this->request['setEntry']['page'];
				}
				else{
					$p = $page;
				}
				// Hole die Daten des geänderten oder neuen Eintrag aus Datenbank
				$data['Entry'] = $this->entries->getEntry($p);
			}
			$data['Action'] = DIR.'?load=page&amp;page='.$p.'&amp;action=edit';
			$data['Delete'] = DIR.'?action=delete&amp;page='.$data['Entry']['page'];
			$data['View'] = \Controller\Helpers::buildLink($p);		
		}
		// im Request ist keine Page enthalten
		else{
			if(!empty($this->success['Entry'])){
				if($this->success['Entry']['error']){
					$data['Entry'] = $this->request['setEntry'];
				}
				else{
					$data['Entry'] = $this->entries->getEntry($this->request['setEntry']['page']);
					if(!empty($data['Entry'])){
						$data['Action'] = DIR.'?load=page&amp;page='.$this->request['setEntry']['page'].'&amp;action=edit';
						$data['View'] = \Controller\Helpers::buildLink($this->request['setEntry']['page']);
					}
				}
			}
			else{
				$data['Entry'] = $this->entries->getEntry('');
			}
			$data['Delete'] = '#" onclick="alert(\'Aktion nicht möglich!\')';
		}
		$data['Success'] = $this->success;
		$data['Navigation'] = $this->entries->getNavigation();
		$data['EnumIndex'] = $this->entries->getDBEnumSet('meta','indexation');
		
		return $data;
	}
	
/**
 * Inhalte Panel editieren
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	public function DataPanel($panel){
		// Lade Inhalt des jweiligen Panel
		$data = array();
		$num = (!empty($panel) and ($panel == 'panel1' or $panel == 'panel2' or $panel == 'panel3')) ? $panel : 'panel1';
		$data['Action'] = DIR.'?load=panel&amp;panel='.$num.'&amp;action=update';
		foreach($this->entries->getPanel() as $note){
			$arrPanel[$note['number']] = $note;
		}
		$data['Panel'] = $arrPanel[$num];
		$data['Success'] = $this->success;
		
		return $data;
	}
	
/**
 * Daten Ausgabe Settings-Seite erzeugen
 *
 * *Description* 
 * 
 * @param
 *
 * @return array 
 */
 
	public function DataSettings(){
		
		$data = array();
		$data['Success'] = $this->success;
		$data['Setting'] = $this->entries->getSiteSettings();
		$data['Setup'] = $this->entries->getSetup();
		$data['Users'] = $this->entries->getAllUsers();
		$data['userRole'] = $this->entries->getRole();
		$data['Template'] = $this->entries->getAllTemplates();
		if(!empty($data['Success']['User'])){
			$data['Tab'] = $this->TabControl(2);
		}
		elseif(!empty($data['Success']['Template'])){
			$data['Tab'] = $this->TabControl(3);
		}
		elseif(!empty($data['Success']['Setup'])){
			$data['Tab'] = $this->TabControl(4);
		}
		else{
			$data['Tab'] = $this->TabControl(1);
		}
		return $data;
	}
	
/**
 * Daten Ausgabe Userseite erzeugen
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	public function DataUsers($user){
		
		$data = array();
		if(!empty($this->success['User']) and $this->success['User']['error']){
			$data['User'] = $this->request['setUser'];
		}
		elseif(!empty($this->success['User']) and !$this->success['User']['error']){
			$data['User'] = $this->entries->getUserData($this->request['setUser']['username']);
		}
		else{
			$data['User'] = $this->entries->getUserData($user);
		}
		$data['Success'] = $this->success;
		$data['EnumUserstatus'] = $this->entries->getDBEnumSet('user','status');
		$data['userRole'] = $this->entries->getRole();
		$data['Action'] = DIR.'?load=user&amp;action=setuser';
		$data['Delete'] = !empty($data['User']['username']) ? DIR.'?load=setting&amp;action=deleteuser&amp;username='.$data['User']['username'] : '#" onclick="alert(\'Aktion nicht möglich!\')';
		$data['User']['registration_date'] = !empty($data['User']['registration_date']) ? \Controller\Helpers::timestampMySQL2German($data['User']['registration_date']) : '';
		
		return $data;
	}
	
/**
 * Daten Ausgabe Pluginseite erzeugen
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	public function DataPlugin($plugin){
		if(file_exists(DIR_PLUGIN.$plugin.'/admin.php')){
			$data['PluginPath'] = DIR_PLUGIN.$plugin.'/admin.php';
		}
		else{
			$data['PluginPath'] = FALSE;
		}
		return $data;
	}
	
/**
 * Tabulator kontrollieren
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
	
	public function TabControl($num = 1){
		$data['Tab'] = array('', '', '', '', '', '');
		if(isset($this->request['tab']) and is_numeric($this->request['tab']) and $this->request['tab'] > 0 and $this->request['tab'] < 6){
			$data[(int)$this->request['tab']] = 'active';
		}
		else{
			$data[$num] = 'active';
		}
		return $data;
	}
	
/**
 * Korrekte Installation checken
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	private function checkInstall(){
		$review = $this->entries->checkDB();
		if($review['error']){
			$this->response->modifyHeader('location', SITEPATH.'install.php', TRUE);
		}
	}
	
/**
 * Sende Header-Information
 *
 * *Description* Sende Header Information, Ausgabe aller PHP header() 
 * 
 * @param 
 *
 * @return array
 */
 
 	private function sendAllHeaders(){
		$this->response->modifyHeader('status', 200);
		$this->response->modifyHeader('content-type', 'text/html');
		$this->response->sendHeaders();
		
		// Sets the default timezone used by all date/time functions in a script
		\Framework\Utility::setTimezone();
	}
}