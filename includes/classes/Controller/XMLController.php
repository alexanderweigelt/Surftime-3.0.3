<?php
    
 /**
 * XML Controller
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
 * Class XMLController
 * @package Controller
 */

class XMLController {

	/**
	 * XMLController constructor.
	 */

	public function __construct() {
		$this->request = array_merge($_GET, $_POST);
		$this->response = new \Framework\Response();
		$this->response->errorReporting();
        $this->xml = new \View\XML(\Framework\Utility::getCharset());
		$this->entries = new \Model\GetContent();
	}
	
	/**
	 * Ausgaben in XML-Datei erzeugen
	 *
	 * *Description*
	 *
	 * @param
	 *
	 * @return string
	 */
 
	public function display(){
		// Modify Header Information
		$this->response->modifyHeader('status', 200);
		$this->response->modifyHeader('content-type', 'text/xml');
		
		// GET Parameter aus URI
		$page = isset($this->request['site']) ? $this->request['site'] : '';
		
		switch ($page) {
		
			case 'sitemap':
				// XML Sitemap
				$xml = $this->xml->sitemap($this->entries->getEntries());
				break;
				
			case 'rss':
				// RSS FEED
				$xml = '';
				break;
				
			case 'plugin':
				// XML aus Plugin
				$xml = $this->loadExtension();
				break;
				
			default:
				$this->response->modifyHeader('status', 404, TRUE);
				$xml = $this->xml->defaultXML('Attention! The requested document is not available.');
				
		}
		
		//Send Header Information
		$this->response->sendHeaders();
		return $xml;	
	}

	/**
	 * @return string
	 */

	public function loadExtension(){
		$xml = '';
		if(!empty($this->request['extension']) and file_exists(DIR_PLUGIN.$this->request['extension'].'/xml.php')){
			include_once(DIR_PLUGIN.$this->request['extension'].'/xml.php');
			if(function_exists('XMLData')){
				//Funktion in Plugin aufrufen
				unset($this->request['extension'], $this->request['site']);
				$xml = XMLData($this->request);
			}
		}
		if(empty($xml)){
			$this->response->modifyHeader('status', 404, TRUE);
			$xml = $this->xml->defaultXML('No data found for : '.$this->request['extension']);
		}
		return $xml;
	}
	
}

?>