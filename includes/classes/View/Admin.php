<?php
    
 /**
 * Admin View 
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
 * Class Admin
 * @package View
 */

class Admin {
	
	private $data;

	/**
	 * Admin constructor.
	 */

	public function __construct(){
        $this->data = [];
    }

	/**
	 * @param $name
	 * @param $value
	 */

	public function __set($name, $value){
        $this->data[$name] = $value;
    }

	/**
	 * @param $name
	 *
	 * @return mixed
	 * @throws \Framework\Exception
	 */

	public function __get($name){
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            throw new \Framework\Exception("$name is missing...");
        }
    }

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed
	 */

	public function __call($name, $arguments){
		$arr_allowed = [
			'Menu' => [
				'args' => [ 'Navigation','Breadcrumb','SingleLink' ],
				'namespace' => '\View\\'
			],
			'Library' => [
				'args' => [ 'jQuery','jQueryUI','Foundation','FoundationJS','Modernizr','Normalize','Lightbox' ],
				'namespace' => '\View\\'
			]
		];
		$call = new \Framework\Caller();
		return $call->callingMethod($name, $arguments, $arr_allowed);
	}

	/**
	 * @return mixed|string
	 */

	public function parse(){
        $output = '';

        $file = DIR_ADMIN.'index.php';
        if (file_exists($file)) {
            ob_start();
            include $file;
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $msg = DIR_ADMIN.'index.php not found';
			$output = \View\Error::errDocument($msg);
        }
        return $output;
    }
}