<?php
    
 /**
 * Base Controller
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class Pages {
	
	/** Eigenschaften definieren */
	public $response;
    public $page;
	public $site;
	public $chkinst;
	public $entries;
	public $settings;
	public $pathTemplate;
	public $template;
	public $contactform_msg;
	public $searchRequest;
	public $searchform;

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
        $this->site = new \View\Site();
		$this->entries = new \Model\GetContent();
		
		// Sets the default timezone used by all date/time functions in a script
		\Framework\Utility::setTimezone();
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
		$maintenance = false;
		$methods = array('checkInstall', 'compression', 'loadPlugin', 'realURL', 'maintenance', 'loadAction', 'sendAllHeaders', 'setTemplate', 'setValues', 'display');
		foreach($methods as $method){
			$$method = $this->$method();
		}
		if($maintenance){
			$display = $maintenance;
		}
		return $display;
	}

	/**
	 * Korrekte Installation checken (Kurzform)
	 *
	 * *Description* Wenn Datenbank noch nicht installiert weiter leiten an Installseite
	 *
	 * @param
	 *
	 * @return
	 */
 
	private function checkInstall(){
		$this->chkinst = true;
		$review = $this->entries->checkDB('short'); 
		if($review['error']){
			// weiter leiten an Install - Page
			$this->response->modifyHeader('status', 302, TRUE);
			$this->response->modifyHeader('location', SITEPATH.'install.php', TRUE);
			$this->chkinst = false;
		}
	}

	/*
	 * Komprimierung aktivieren
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return void
	 */

	private function compression(){
		if($this->chkinst){
			$setup = $this->entries->getSetup();
			if(!empty($setup['compress']) and $setup['compress'] == TRUE and extension_loaded("zlib") and strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")){
				//PHP compression
				if(defined('DEBUG_MODE') and !DEBUG_MODE) ob_start("ob_gzhandler");
				\Controller\Helpers::setGlobals('Compression', TRUE);
			}
		}
	}

	/**
	 * Plugin laden
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return array
	 */

	private function loadPlugin(){
		\Model\LoadExtensions::PluginLoader();
	}
	
	/**
	 * Dateiname aus URL holen
	 *
	 * *Description* Übergebene GET Parameter aus URI verarbeiten
	 *
	 * @param string
	 *
	 * @return string
	 */
 
	private function realURL($uri = NULL){
		
		$this->page = MAINPAGE;
		
		if(empty($uri)){
			$site = isset($this->request['site']) ? $this->request['site'] : NULL;
		}
		else{
			$site = $uri;
		}
		if(!empty($site) and $this->chkinst) {
			$path_parts = pathinfo($site);
			$categorys = $this->isCategory($path_parts['dirname']);
			$is_site = $this->isSite($path_parts['filename']);	
		
			if(isset($path_parts['extension']) and $is_site and $path_parts['extension'] == EXTENSION and URL_REWRITING and empty($categorys)){
				$this->response->modifyHeader('status', 200);
				$this->page = $path_parts['filename'];
			}
			elseif($is_site and !URL_REWRITING and empty($categorys)){
				$this->response->modifyHeader('status', 200);
				$this->page = $path_parts['filename'];
			}
			else{
				$this->page = 'error';
				// Weiterleitung 404 Fehlerseite
				if($this->isSite($this->page)){
					$filename = \Controller\Helpers::buildLink($this->page);
				}
				else{
					$filename = \Controller\Helpers::getHost().'/';
				}
				// Set 404 response code
				$this->response->modifyHeader('status', 404, TRUE);
				$this->response->modifyHeader('location', $filename, TRUE);
			}
			
			// Weiterleitung Fehlerseite oder Admin
			if($this->page == 'admin'){
				$this->response->modifyHeader('status', 301, TRUE);
				$this->response->modifyHeader('location', \Controller\Helpers::getHost().'/admin.php', TRUE);
			}
			
        }
		//Page als globale Variable verfügbar machen
		\Controller\Helpers::setGlobals('Page', $this->page);
	}

	/*
	 * Maintenance Page
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return boolean
	 */

	private function maintenance(){
		if($this->chkinst){
			$setup = $this->entries->getSetup();
			if(!empty($setup['maintenance']) and $setup['maintenance'] == true){
				$html = 'Wartung! Wir sind gleich wieder da.';
				$path = PATH_PAGES.MAINTENANCE;
				if(file_exists($path)){
					$html = file_get_contents($path);
				}
				$this->response->modifyHeader('retry-after', 3600);
				$this->response->modifyHeader('status', 503, TRUE);
				return $html;
			}
			return false;
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
		
		if(isset($this->request['action']) and $this->chkinst){
			
			switch ($this->request['action']) {
		
			case 'form':
				// FormController
				$action = new \Controller\ContactFormController();
				$this->contactform_msg = $action->sendMessage($this->request);
				break;
				
			case 'search':
				// SearchController
				$action = new \Controller\SearchController();
				$action->response = $this->response;
				$this->searchRequest = $action->startSearch($this->request['searchterm'], $this->page);
				break;
				
			}	
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
		$this->response->modifyHeader('content-type', 'text/html');
		$this->response->sendHeaders();
		//$this->response->dumpHeader();
	} 

	/**
	 * Statisches Template setzen
	 *
	 * *Description* Statisch hinterlegtes Layout für Seite als Template setzen.
	 *
	 * @param string
	 *
	 * @return string
	 */
	
    public function setTemplate(){
		//Template setting
		$setup = $this->entries->getSetup();
		$this->pathTemplate = THEME_DIR.$setup['template'].'/';
        if(file_exists($this->pathTemplate.$this->page.'.php')){
            $this->template = $this->pathTemplate.$this->page.'.php';
        }
        elseif(file_exists($this->pathTemplate.'index.tpl.php')){
            $this->template = $this->pathTemplate.'index.tpl.php';
        }
        else{
            $this->template = FALSE;
        }
    }

	/**
	 * Setzt Variablen für Verwendung im Template
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return object
	 */
 
	private function setValues(){
		
		// HTML-Gerüst Head, Closing Structure
		$arr_allowed = array(
			'firstname','lastname','street','postalzip','city','phone','email','company','opening','variable','keywords','description','slogan','headline','content','title','indexation', 'panel1', 'panel2', 'panel3', 'pathTemplate', 'searchform', 'charset'
		);
		
		// Lade alle Daten in einen Array
		$var = array_merge(
			$this->entries->getEntry($this->page), 
			$this->Panel(), 
			$this->entries->getSiteSettings(), 
			array(
				'pathTemplate' => $this->pathTemplate, 
				'searchform' => $this->getHTMLForms('Search'),
				'charset' => \Framework\Utility::getCharset()
			)
		); 
		foreach($var as $key => $value) {
			if(in_array($key, $arr_allowed)){
				$name = ucfirst($key);
				//Handling Content
				if($key == 'content'){
					// Compile Content
					$this->site->$name = !empty($this->searchRequest) ? $this->searchRequest : $this->compileContent($value);
				}
				elseif($key == 'panel1' or $key == 'panel2' or $key == 'panel3'){
					// Compile Panel
					$this->site->$name = $this->compileContent($value);
				}
				else{
					// Other Values ...
					$this->site->$name =  $value;
				}
			}
		}	
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
 
    public function display() {
		
		try {
			// Parse View - Site
			$html = $this->site->parse($this->template);
			return $html;
		}
		catch (\Framework\Exception $e) {
			// handling InvalidArgumentException
			return $e->getMessage();
		}
		
    }
	
	/**
	 * Pruefe ob Seite im System existiert
	 *
	 * *Description*
	 *
	 * @param string
	 *
	 * @return boolean
	 */
 
	public function isSite($site){
		
		$sites = new \Controller\NavController();
		return $sites->checkSite($site);
	}
	
	/**
	 * Pruefe ob Kategorie existiert
	 *
	 * *Description* Funktion inaktiv (dient zu späteren Erweiterung in Kategorien zu speichern)
	 *
	 * @param string
	 *
	 * @return boolean
	 */

	public function isCategory($dirname){
		// Kategorien aus Ordnerstruktur bilden
		if(empty($dirname) or preg_match('/^[.+]$/', $dirname)){
			return NULL;
		}
		else{
			$arrCategorys = explode('/', $dirname);
			// Prüfung möglicher Kategorien aus DB später einfügen ...
			
			return $arrCategorys;
		}
	}

	/**
	 * Content kompilieren
	 *
	 * *Description*
	 *
	 * @param string
	 *
	 * @return string
	 */
 
	private function compileContent($text){
		$arrSearch = array();
		$arrReplace = array();
		
		// Such-Parameter (Platzhalter im Text)
		$arrSearch = array(
			'{%CONTACTFORM%}',
			'{%CONTACTFORM_MESSAGE%}',
			'{%SEARCHFORM%}'
					);
					
		// Ersetzungs-Parameter (Variablen von außerhalb der Funktion)
		$arrReplace = array(
			$this->getHTMLForms('Contact'), // Lade Contactform HTML
			$this->contactform_msg,
			$this->getHTMLForms('Search')
					);
		
		//Übergebene Daten aus $values umschreiben und an den jeweiligen Array anhängen
		foreach($this->entries->getSiteSettings()  as $k => $v){
			if(is_numeric($k)){
				$search = '{%VALUE'.$k.'%}';
			}
			else{
				$search = '{%'.strtoupper($k).'%}';
			}
			array_push($arrSearch, $search);
			array_push($arrReplace, $v);                    
		}
	
		//Plugin innerhalb des Content laden
		preg_match_all('/{%FUNCTION\S*%}/', $text, $matches, PREG_SET_ORDER);		
		foreach($matches as $match){
			preg_match('/[^{%FUNCTION\|].*[^%}]/', $match[0], $_func);
			$func = preg_split('/\|/', $_func[0]);
			$name = (string)array_shift($func);
			$err_msg = '<strong>Warning:</strong> Plugin Function <em>'.$name.'</em> not found in '.$match[0];
			if(file_exists(DIR_PLUGIN.$name.'/index.php')){
				include_once(DIR_PLUGIN.$name.'/index.php');
				$plugin = function_exists($name) ? $name($func) : $err_msg;
			}
			else{
				$plugin = $err_msg;
			}
			array_push($arrSearch, $match[0]);
			array_push($arrReplace, $plugin);
		}
		
		// Suchen & Ersetzen im Content
		$content = str_replace($arrSearch, $arrReplace, $text);	
				
		return $content;	
	}
	
	/**
	 * HTML Formulare laden
	 *
	 * *Description*
	 *
	 * @param string
	 *
	 * @return boolean
	 */
 
	private function getHTMLForms($form = NULL){
		switch($form){
			case 'Search':
				$path = PATH_PAGES.SEARCHFORM;
				$url = \Controller\Helpers::buildLink('search');
			break;
			case 'Contact':
				$path = PATH_PAGES.CONTACTFORM;
				$url = \Controller\Helpers::buildLink($this->page);
			break;
		}
		if(file_exists($path)){
			$html = sprintf(file_get_contents($path), $url);
		}
		else{
			$html = '<strong>Warning:</strong> Form/'.$form.' not found';
		}
		return $html;
	}
	
	/**
	 * Inhalte Panel
	 *
	 * *Description* Formatiert den Array aus Übergabe DB um.
	 *
	 * @param
	 *
	 * @return array
	 */
 
 	private function Panel(){
		foreach($this->entries->getPanel() as $note){
			$panel[$note['number']] = $note['widget'];
		}
		return $panel;
	}

}

?>