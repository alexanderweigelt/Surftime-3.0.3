<?php
    
 /**
 * Installation CMS Controller
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
  * Class InstallController
  * @package Controller
  */

 class InstallController {
	
	/** Eigenschaften definieren */
	private $install;
	public $view;
	public $review;
	
    /**
     * Constructor
     *
     * *Description*
     */
 
	public function __construct() {
        $this->request = array_merge($_GET, $_POST);
        $this->response = new \Framework\Response();
        $this->response->errorReporting();

        // Sets the default timezone used by all date/time functions in a script
        \Framework\Utility::setTimezone();

        $this->site = new \View\Install();
        $this->entries = new \Model\GetContent();

        // Neue Session starten
        $this->session = new \Framework\Session('INSTALL');
	}

	/**
	 * Load methods
	 *
	 * *Description*
	 *
	 * @return string
	 */

	public function run(){
        $display = 'nothing to see ...';
		$methods = [ 'startInstall', 'sendAllHeaders', 'display' ];
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
     * @return mixed
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
     */

    public function finalStep(){
        if($this->session->readSession('install_step') === 4) {
            if($this->request['password'] === INSTALL_PASS) {
	            $this->session->writeSession( 'role', 'admin' );
	            $this->install = new \Model\InstallModel();
	            if ( $this->install->runInstallation() ) {
		            $successInstall['message'] = 'Success install: <br>' . "\n";
		            foreach ( $this->install->getSuccessInstallation() as $key => $value ) {
			            $successInstall['message'] .= "\n <br><strong>" . $key . '</strong><br><br>';
			            foreach ( $value as $text ) {
				            $successInstall['message'] .= "\n" . '* ' . $text . '<br>' . "\n";
			            }
		            }
		            $arrMessage['firstlogin'] = '
                        <p>Administration - Login <br>
                        Username: ' . \Model\InstallModel::DEFAULT_USER . '<br>
                        Password: ' . \Model\InstallModel::DEFAULT_PASS . '</p>';
		            $message                  = array_merge( $successInstall, $arrMessage );
		            $this->session->deleteSession( 'install_step' );
		            $this->view = $this->site->finalStep( $message );
	            } else {
		            $this->session->destroySession();
		            $this->view = $this->site->error( 'Fehler: Schreiben der Datenbanktabellen nicht möglich!' );
	            }
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
	 */

	private function sendAllHeaders(){
		$this->response->modifyHeader('status', 503);
		$this->response->modifyHeader('content-type', 'text/html');
		$this->response->sendHeaders();
	}
}

?>