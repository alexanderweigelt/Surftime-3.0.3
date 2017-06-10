<?php
    
 /**
 * Admin Controller
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
 * Class AdminController
 * @package Controller
 */

class AdminController {
	
	/** Properties */
	private $login;
	private $entries;
	private $success = [];
	private $view;
	private $request;
	private $libs;
	private $page;

	/**
	 * AdminController constructor.
	 */

	public function __construct() {
		$this->response = new \Framework\Response();
		$this->response->errorReporting();
	}

	/**
	 * Load methods for Admin Pages
	 *
	 * *Description* Start a loop to load all methods for Admin Pages
	 *
	 * @return string
	 */

	public function run(){
		$display = 'nothing to see ...';
		$methods = [
			'setEntries',
			'checkInstall',
			'sendAllHeaders',
			'setRequest',
			'setLoginController',
			'setLibs',
			'setViewAdmin',
			'loadAction',
			'setCurrentPage',
			'display'
		];
		foreach($methods as $method){
			$$method = $this->$method();
		}
		return $display;
	}

	/**
	 * Returns a instance of Library View
	 *
	 * @return \View\Library
	 */

	public function getLibs() {
		return $this->libs;
	}

	/**
	 * Set View Library on var $libs
	 */

	public function setLibs() {
		$this->libs = new \View\Library();
	}

	/**
	 * Returns a merged POST and GET request
	 *
	 * @param null $key
	 *
	 * @return mixed
	 */

	public function getRequest( $key = NULL ) {
		if( isset($key) ){
			return $this->request[$key];
		}
		return $this->request;
	}

	/**
	 * Set merged request param POST and Get on var $request
	 */

	public function setRequest() {
		$request = array_merge($_GET, $_POST);
		$this->request = !empty($request) ? $request : [];
	}

	/**
	 * Returns a instance of LoginController
	 *
	 * @return \Controller\LoginController
	 */

	public function getLoginController() {
		return $this->login;
	}

	/**
	 * Set Controller LoginController on var $login
	 */

	public function setLoginController() {
		$this->login = new \Controller\LoginController();
		$this->login->setEntriesData( $this->getEntries() );
		$this->login->setRequest( $this->getRequest() );
		$this->login->setResponse( $this->response );
		// Handle Login
		$this->login->setMaxLifetime( 3600 * 24 * 7 );
		$this->login->SetDurationLogin();
	}

	/**
	 * Returns a instance of GetContent Model
	 *
	 * @return \Model\GetContent
	 */

	public function getEntries() {
		return $this->entries;
	}

	/**
	 * Set Model GetContent on var $entries
	 */

	public function setEntries() {
		$this->entries = new \Model\GetContent();
	}

	/**
	 * Returns a instance of Admin View
	 */
	public function getViewAdmin() {
		return $this->view;
	}

	/**
	 * Set View Admin on var $view
	 */
	public function setViewAdmin() {
		$this->view = new \View\Admin();
	}

	/**
	 * Load action Models and Controllers
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return
	 */

	private function loadAction(){

		if($this->getRequest('action') and $this->getLoginController()->CheckLogin()) {
			$action = new \Controller\ActionsController();
			$action->setRequestData( $this->getRequest() );
			$action->setEntriesData( $this->getEntries() );

			switch ($this->getRequest('action')) {

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
					$this->getLoginController()->Logout();
					break;

			}
		}

		if( $this->getRequest('action') ){
			switch ($this->getRequest('action')) {

				case 'login':
					// Login
					$this->success['classFormLogin'] = $this->getLoginController()->SetLogin();
					break;

				case 'forgetpassword':
					// Forget password
					$this->success['ForgetPassword'] = $this->getLoginController()->sendForgetPassword();
					break;
			}
		}
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

	private function display() {

		//Load content start here
		define('DIR_PROTECTION',TRUE);	
		
		if($this->getLoginController()->CheckLogin()){

			switch($this->page) {
				
				case 'start':
					//Data Start Dashboard
					$this->getViewAdmin()->Data = $this->DataStart();
					break;
					
				case 'page':
					//Data Edit Page
					$editPage = $this->getRequest('page') ? $this->getRequest('page') : '';
					$this->getViewAdmin()->Data = $this->DataPage($editPage);
					break;
			
				case 'setting':
					//Data Site Settings
					$this->getViewAdmin()->Data = $this->DataSettings();
					break;
					
				case 'user':
					//Data Edit User 
					$editUser = $this->getRequest('user') ? $this->getRequest('user') : '';
					$this->getViewAdmin()->Data = $this->DataUsers($editUser);
					break;
				
				case 'plugin':
					//Data Edit User 
					$editPlugin = $this->getRequest('plugin') ? $this->getRequest('plugin') : '';
					$this->getViewAdmin()->Data = $this->DataPlugin($editPlugin);
					break;	
					
				case 'panel':
					//Data Edit Panel
					$editPanel = $this->getRequest('panel') ? $this->getRequest('panel') : '';
					$this->getViewAdmin()->Data = $this->DataPanel($editPanel);
					break;	
			}
		}
		else{
			$this->getViewAdmin()->Data = $this->DataLogin();
		}
		// Load System Infos
		$this->getViewAdmin()->SystemInfo = $this->getEntries()->readSystemInfos();
		// Load Library
		$this->getViewAdmin()->Library = $this->getLibs();

        try {
            return $this->getViewAdmin()->parse();
        } catch (\Framework\Exception $e) {
            return $e->getMessage();
        }
		
	}

	/**
	 * Set the current page with site content for admin view
	 */

	private function setCurrentPage(){
		$statusLogin = $this->getLoginController()->CheckLogin();
		$p = (string)$this->getRequest( 'load' );
		$this->page = 'login';
		if ( $p and $statusLogin ) {
			$this->page = $p;
		}
		if ( !$p and $statusLogin ){
			$this->page = 'start';
		}
		if ( $p === 'forgetpassword' ){
			$this->page = 'forgetpassword';
		}
		//White list Param load
		if ( !file_exists( DIR_ADMIN . 'pages/' . $this->page . '.php' ) ) {
			$this->page = 'error';
		}

		$this->getViewAdmin()->siteContent = DIR_ADMIN . 'pages/' . $this->page . '.php';
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

	private function DataLogin(){
		$data = [];
		if( !empty($this->success['classFormLogin']) ){
			$data['Class'] = $this->success['classFormLogin'];
		}
		else {
			$data['Class'] = '';
		}
		$data['Action'] = DIR.'?load=forgetpassword';

		return $data;
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

	private function DataStart(){
		$data = [];
		//Split Entries for pagination
		$num = ($this->getRequest('num') and is_numeric($this->getRequest('num'))) ? (int)$this->getRequest('num') : 0;
		$limit = 10;
		
		$data['Entries'] = \Controller\Helpers::paganation($this->getEntries()->getEntries(), $num, $limit);
		$data['Pager']['pageNumber'] = $num;
		$data['Pager']['countEntries'] = count($this->getEntries()->getEntries());
		$data['Pager']['limitEntries'] = $limit;
		$data['AllImages'] = $this->getEntries()->getAllImages();
		foreach($this->getEntries()->getPanel() as $note){
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

	private function DataPage($page = ''){
		// Lade Inhalt Single Page
		$data = [];
		$data['Action'] = DIR.'?load=page&amp;action=insert';
		$setEntry = $this->getRequest('setEntry');
		// im GET-Parameter ist die Page enthalten
		if(!empty($page)){
			// ActionController gibt einen Error zurück
			if(!empty($this->success['Entry']) and $this->success['Entry']['error']){
				$data['Entry'] = $setEntry;
			}
			// ActionController meldet Eintrag erfolgreich
			else{
				// wurde der Dateiname geändert, lese Inhalte für diesen
				if(!empty($setEntry['page']) and $page != $setEntry['page']){
					if ( isset( $this->success['Entry']['fixedPage'] ) ) {
						$p = $this->success['Entry']['fixedPage'];
					} else {
						$p = $setEntry['page'];
					}
				}
				else{
					$p = $page;
				}
				// Hole die Daten des geänderten oder neuen Eintrag aus Datenbank
				$data['Entry'] = $this->getEntries()->getEntry($p);
			}
			$data['Action'] = DIR.'?load=page&amp;page='.$p.'&amp;action=edit';
			$data['Delete'] = DIR.'?action=delete&amp;page='.$data['Entry']['page'];
			$data['View'] = \Controller\Helpers::buildLink($p);		
		}
		// im Request ist keine Page enthalten
		else{
			if(!empty($this->success['Entry'])){
				if($this->success['Entry']['error']){
					$data['Entry'] = $setEntry;
				}
				else{
					$data['Entry'] = $this->getEntries()->getEntry($setEntry['page']);
					if(!empty($data['Entry'])){
						$data['Action'] = DIR.'?load=page&amp;page='.$setEntry['page'].'&amp;action=edit';
						$data['View'] = \Controller\Helpers::buildLink($setEntry['page']);
					}
				}
			}
			else{
				$data['Entry'] = $this->getEntries()->getEntry('');
			}
			$data['Delete'] = '#" onclick="alert(\'Aktion nicht möglich!\')';
		}
		$data['Success'] = $this->success;
		$data['Navigation'] = $this->getEntries()->getNavigation();
		$data['EnumIndex'] = $this->getEntries()->getDBEnumSet('meta','indexation');
		
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

	private function DataPanel($panel){
		// Lade Inhalt des jweiligen Panel
		$data = [];
		$arrPanel = [];
		$num = !empty($panel) ? $panel : 'panel1';
		$data['Action'] = DIR.'?load=panel&amp;panel='.$num.'&amp;action=update';
		foreach($this->getEntries()->getPanel() as $note){
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

	private function DataSettings(){
		
		$data = [];
		$data['Success'] = $this->success;
		$data['Setting'] = $this->getEntries()->getSiteSettings();
		$data['Setup'] = $this->getEntries()->getSetup();
		$data['Users'] = $this->getEntries()->getAllUsers();
		$data['userRole'] = $this->getEntries()->getRole();
		$data['Template'] = $this->getEntries()->getAllTemplates();
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

	private function DataUsers($user){
		
		$data = [];
		$setUser = $this->getRequest('setUser');
		if(!empty($this->success['User']) and $this->success['User']['error']){
			$data['User'] = $setUser;
		}
		elseif(!empty($this->success['User']) and !$this->success['User']['error']){
			$data['User'] = $this->getEntries()->getUserData($setUser['username']);
		}
		else{
			$data['User'] = $this->getEntries()->getUserData($user);
		}
		$data['Success'] = $this->success;
		$data['EnumUserstatus'] = $this->getEntries()->getDBEnumSet('user','status');
		$data['userRole'] = $this->getEntries()->getRole();
		$data['Action'] = DIR.'?load=user&amp;action=setuser';
		if ( ! empty( $data['User']['username'] ) ) {
			$data['Delete'] = DIR . '?load=setting&amp;action=deleteuser&amp;username=' . $data['User']['username'];
		} else {
			$data['Delete'] = '#" onclick="alert(\'Aktion nicht möglich!\')';
		}
		if ( ! empty( $data['User']['registration_date'] ) ) {
			$data['User']['registration_date'] = \Controller\Helpers::timestampMySQL2German( $data['User']['registration_date'] );
		} else {
			$data['User']['registration_date'] = '';
		}
		
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

	private function DataPlugin($plugin){
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

	private function TabControl($num = 1){
		$data['Tab'] = [ '', '', '', '', '', '' ];
		if(
			$this->getRequest('tab') and
			is_numeric($this->getRequest('tab')) and
			$this->getRequest('tab') > 0 and
			$this->getRequest('tab') < 6
		){
			$data[(int)$this->getRequest('tab')] = 'active';
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
		$review = $this->getEntries()->checkDB();
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