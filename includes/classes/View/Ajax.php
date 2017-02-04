<?php
    
 /**
 * Ajax and JSON View
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace View;


/**
 * Class Ajax
 * @package View
 */

class Ajax {

	/**
	 * Ajax constructor.
	 */

	public function __construct(){
				
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */

	public function JsonList($data){
		return json_encode($data);
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */

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

	/**
	 * @param $param
	 *
	 * @return mixed|string
	 */

	public function ViewErrorMessage($param){
		$msg = 'Incorrect information in the parameters used : '.$param;
		return \View\Error::errDocument($msg);
	}
}

?>