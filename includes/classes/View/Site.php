<?php
    
 /**
 * Site View
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
 * Class Site
 * @package View
 */

class Site {
	
    private $data;
    public $compress;

	/**
	 * Site constructor.
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
            throw new \Framework\Exception("Can't get property $name!");
        }
    }

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed
	 */

	public function __call($name, $arguments){
		$arr_allowed = array(
			'Menu' => array(
				'args' => array('Navigation','Breadcrumb','SingleLink'),
				'namespace' => '\View\\'
			),
			'Library' => array(
				'args' => array('jQuery','jQueryUI','Foundation','FoundationJS','Modernizr','Normalize','Lightbox'),
				'namespace' => '\View\\'
			)
		);
		$call = new \Framework\Caller();
		return $call->callingMethod($name, $arguments, $arr_allowed);
	}

	/**
	 * @param $file
	 *
	 * @return mixed|string
	 */

	public function parse($file){
        $output = '';
        if($file){
            ob_start();
            include $file;
            $html = ob_get_contents();
            ob_end_clean();
            $output = \Model\LoadExtensions::AddPlugin($html);
        }
        else{
			$msg = "Template nicht gefunden";
			$output = \View\Error::errDocument($msg);
        }

        return $output;
    }	
}

?>