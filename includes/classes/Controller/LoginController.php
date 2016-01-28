<?php
    
 /**
 * Login Controller
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class LoginController {
	
	/** Eigenschaften definieren */
	public $loginData = array();
	private $entries;
    private $maxLifetime;

/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
    public function __construct() {
		$this->entries = new \Model\GetContent();
		$this->loginData['classFormLogin'] = '';
		
		// Neue Session starten
        $this->maxLifetime = 3600 * 24 * 7;
		$this->Session = new \Framework\Session('LOGIN');
	}
	
/**
 * Einloggen
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	public function SetLogin() {
		$this->SetDurationLogin();
		if(isset($_POST['loginSubmit'])){
		
			foreach($_POST as $k => $v){
				$$k = trim(strip_tags($v));
			}
			if(empty($loginUser) or empty($loginPass)){
				$this->loginData['classFormLogin'] = 'error';
			}
			else{	
				// Daten aus Datenbank für Admin auslesen
				$login = $this->entries->getUserData($loginUser);
		
				if($login['password'] === crypt($loginPass, $login['password'])){
					$this->Session->writeSession('auth', true);
                    $this->Session->writeSession('password', $login['passowrd']);
                    // set up user roles and permissions
                    $this->Session->writeSession('role', $login['status']);
					
					header('Location: '.DIR.'?tab=1');
					exit();
				}
				else{
					$this->loginData['classFormLogin'] = 'error';
                    $this->Session->destroySession();
				}
			}
		}
	}
	
/**
 * Login Status checken
 *
 * *Description* 
 * 
 * @param
 *
 * @return boolean
 */
 
	public function CheckLogin() {
		$login = FALSE;
        $auth = $this->Session->readSession('auth');
		if(!empty($auth) and $auth === true){
			$login = TRUE;
		}
		return $login;
	}
	
/**
 * Ausloggen 
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	public function Logout(){
		$this->Session->destroySession();
		header('LOCATION: '.DIR);
		exit();
	}

    /**
     * Set Duration login
     *
     * *Description*
     *
     * @param
     *
     * @return void
     */

    private function SetDurationLogin(){
        $setup = $this->entries->getSetup();
        if(empty($setup['logout']) and $setup['logout'] == false){
            $this->Session->setLifetime($this->maxLifetime);
        }
    }
}