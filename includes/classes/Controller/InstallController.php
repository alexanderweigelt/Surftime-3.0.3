<?php
    
 /**
 * Installation CMS Controller
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class InstallController {
	
	/** Eigenschaften definieren */
	private $install;
	public $view;
	public $review;
	
    /**
     * Konstruktor
     *
     * *Description*
     *
     * @param
     *
     * @return void
     */
 
	public function __construct() {
        $this->request = array_merge($_GET, $_POST);
        $this->response = new \Framework\Response();
        $this->response->errorReporting();

        // Sets the default timezone used by all date/time functions in a script
        \Framework\Utility::setTimezone();

        $this->site = new \View\Install();
        $this->install = new \Model\InstallModel();
        $this->entries = new \Model\GetContent();

        // Neue Session starten
        $this->session = new \Framework\Session('INSTALL');
	}

	/**
	 * Lade Methoden
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return
	 */

	public function run(){
        $display = 'nothing to see ...';
		$methods = array('startInstall', 'sendAllHeaders', 'display');
		foreach($methods as $method){
			$$method = $this->$method();
		}
		return $display;
	}

    /**
     * Ausgaben im Frontend erzeugen
     *
     * *Description*
     *
     * @param
     *
     * @return array
     */
	
	public function display(){
        try {
            // Parse View - Install
            return $this->site->parse($this->view);
        }
        catch (\Framework\Exception $e) {
            // handling InvalidArgumentException
            return $e->getMessage();
        }
	}

    /**
     * Installation System starten
     *
     * *Description*
     *
     * @param
     *
     * @return
     */

    public function startInstall(){
        $this->review = $this->entries->checkDB();
        if($this->review['error']){
            // Installation kann gestartet werden
            if(isset($this->request['action']) and $this->session->readSession('install_auth') === true){
                $this->loadAction();
            }
            else{
                $this->firstStep();
            }
        }
        else{
            // Installation wird verweigert
            $this->session->destroySession();
            $this->view = $this->site->error('Fehler: Installation nicht möglich!');
        }
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

    public function loadAction(){

        switch ($this->request['action']) {

            case 'step2':
                // Step 2
                $this->secondStep();
                break;

            case 'step3':
                // Start
                $this->thirdStep();
                break;

            case 'step4':
                // Step 3
                $this->finalStep();
                break;

            default:
                $this->session->destroySession();
                $this->view = $this->site->error('Fehler: Installation abgebrochen');
        }

    }

    /**
     * Step 1
     *
     * *Description*
     *
     * @param
     *
     * @return
     */

    public function firstStep(){
        $this->session->writeSession('install_auth', true);
        $this->session->writeSession('install_step', 2);
        $i = 1;
        $message = 'Status der aktuellen Installation: <br>'."\n";
        foreach($this->review['message'] as $msg){
            $message .= $i.'. '.$msg.'<br>'."\n";
            $i++;
        }

        $this->view = $this->site->step1($message);
    }

    /**
     * Step 2
     *
     * *Description*
     *
     * @param
     *
     * @return array
     */

    public function secondStep(){
        if($this->session->readSession('install_step') === 2){
            $this->session->writeSession('install_step', 3);
            // Load System Info
            $message = $this->entries->readSystemInfos();
            $this->view = $this->site->step2($message);
        }
        else{
            $this->session->destroySession();
            $this->view = $this->site->error('Fehler: Installation abgebrochen!');
        }
    }

    /**
     * Step 3
     *
     * *Description*
     *
     * @param
     *
     * @return array
     */

    public function thirdStep(){
        if($this->session->readSession('install_step') === 3 and $this->request['accept'] == true){
            $this->session->writeSession('install_step', 4);
            $this->view = $this->site->step3();
        }
        else{
            $this->session->destroySession();
            $this->view = $this->site->error('Fehler: Installation abgebrochen!');
        }
    }

    /**
     * Final Step
     *
     * *Description*
     *
     * @param
     *
     * @return array
     */

    public function finalStep(){
        if($this->session->readSession('install_step') === 4) {
            if($this->request['password'] === INSTALL_PASS) {
                $successInstall = $this->install->runInstallation();
                $this->session->deleteSession('install_step');
                $arrMessage['firstlogin'] = '
                        <p>Administration - Login <br>
                        Username: ' . \Model\InstallModel::DEFAULT_USER . '<br>
                        Password: ' . \Model\InstallModel::DEFAULT_PASS . '</p>';
                $message = array_merge($successInstall, $arrMessage);
                $this->view = $this->site->finalStep($message);
            }
            else{
                $this->view = $this->site->error('Das Installationspasswort stimmt nicht überein!');
                $this->view .= $this->site->step3();
            }
        }
        else{
            $this->session->destroySession();
            $this->view = $this->site->error('Fehler: Installation abgebrochen!');
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
		$this->response->modifyHeader('status', 503);
		$this->response->modifyHeader('content-type', 'text/html');
		$this->response->sendHeaders();
	}
}

?>