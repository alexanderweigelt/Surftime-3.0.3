<?php
    
 /**
 * Ajax and JSON Controller 
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class AJAXController {
	
	/** Eigenschaften definieren */
	public $entries;
	public $ajax;
	
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
		$this->request = array_merge($_GET, $_POST);
		$this->response = new \Framework\Response();
		$this->response->errorReporting();
		$this->entries = new \Model\GetContent();
	}
	
/**
 * Ausgaben AJAX Daten erzeugen
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	public function display() {
		
		// Load action Models and Controllers
		$action = (isset($this->request['load'])) ? $this->request['load'] : '';
		$this->ajax = new \View\Ajax();
		$data = isset($this->request['data']) ? $this->loadData($this->request['data']) : '';
		$this->response->modifyHeader('status', 200);
		
		switch ($action) {
			
			case 'json':
				// JSON
				$this->response->modifyHeader('content-type', 'application/json');
				$ajx = $this->ajax->JsonList($data);			
				break;
				
			case 'ajax':
				// Ajax
				$this->response->modifyHeader('content-type', 'text/plain');
				$ajx = $this->ajax->ViewAjax($data);
				break;
				
			default:
				//PHP-header
				$this->response->modifyHeader('status', 404, TRUE);
				$this->response->modifyHeader('content-type', 'text/html');
				$ajx = $this->ajax->ViewErrorMessage($action);
		}
		//Send Header Information
		$this->response->sendHeaders();
		return $ajx;
	}
	
/**
 * Daten laden
 *
 * *Description* 
 * 
 * @param string
 *
 * @return array 
 */
 
	private function loadData($param){
		$data = array();
		switch ($param) {
			
			case 'image_list':
				$i = 0;
				foreach($this->entries->getAllImages() as $images){
					$data[$i]['title'] = 'Thumbnail '.$images['alt'];
					$data[$i]['value'] = $images['thumb'];
					$i++;
					$data[$i]['title'] = $images['alt'];
					$data[$i]['value'] = $images['large'];
					$i++;
				}
				break;
				
			case 'link_list':
				$i = 0;
				foreach($this->entries->getNavigation() as $navigation){
					$data[$i]['title'] = !empty($navigation['anchor']) ? $navigation['anchor'] : ucfirst(str_replace('-', ' ', $navigation['page']));
					$data[$i]['value'] = \Controller\Helpers::buildLink($navigation['page']);
					$i++;
				}
				break;	
				
			case 'plugin':
				if(!empty($this->request['extension']) and file_exists(DIR_PLUGIN.$this->request['extension'].'/ajax.php')){
					include_once(DIR_PLUGIN.$this->request['extension'].'/ajax.php');
					if(function_exists('AjaxData')){
						//Funktion in Plugin aufrufen GET-Parameter als Array übergeben
						unset($this->request['extension'], $this->request['data'], $this->request['load']);
						$data = AjaxData($this->request);
					}
					else{
						$data = array('No data found for '.$this->request['extension']);
					}
				}
				break;
				
			default:
				$data = array('Sorry! Nothing found.');
		}
		
		return $data;
	}
}

?>