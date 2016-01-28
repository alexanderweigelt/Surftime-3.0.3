<?php
    
 /**
 * Ajax and JSON View
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace View;


class Ajax {
	
	public function __construct(){
				
	}
	
	public function JsonList($data){
		return json_encode($data);
	}
	
	public function ViewAjax($data){
		$view = '';
		if(is_array($data)){
			foreach($data as $item){
				$view.= $item."\n";
			}
		}
		else{
			$view = $data;
		}
		return $view;
	}
	
	public function ViewErrorMessage($param){
		$msg = 'Incorrect information in the parameters used : '.$param;
		return \View\Error::errDocument($msg);
	}
}

?>