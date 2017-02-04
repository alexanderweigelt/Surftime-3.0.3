<?php
    
 /**
 * Caller
 *
 * *Description* Calling request Method
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Framework;
 

class Caller {
	
	protected $newObjekt;
	
	protected $namespace = '';

	public function callingMethod($name, $arguments = array(), $arr_allowed = array()){
		
		$method = array_shift($arguments);
		$objName = $name;
		
		if($this->checkArrAllowed($name, $method, $arr_allowed)){
			
			$objName = $this->namespace.$objName;
			$this->newObjekt = new $objName();
			
			if(method_exists($objName, $method)){
				return $this->newObjekt->$method($arguments);
			}
			else{
				echo '<strong>Warning:</strong> '.$method.' is missing...<br>';
				if(!empty($arguments)){
					echo 'The arguments passed are: ';
					foreach($arguments as $args){
						echo $args.'<br>';	
					}
				}
			}
		}
		else{
			echo "<strong>Warning:</strong> The calling method ".$objName."::".$method."() is not allowed";
		}
	}
	
	private function checkArrAllowed($obj, $method, $arr){
		
		$check = FALSE;
		if(!empty($arr)){
			foreach($arr as $arrObj => $value){
				if($arrObj == $obj){
					$check = TRUE;
					if(!empty($value['namespace'])){
						$this->namespace = $value['namespace'];
					}
					if(!empty($value['args']) and !in_array($method, $value['args'])){
						$check = FALSE;
						break;
					}
				}
			}
		}
		else{
			$check = TRUE;
		}
				
		return $check;	
	}
	
}