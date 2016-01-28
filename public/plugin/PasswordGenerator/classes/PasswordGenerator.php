<?php

class PasswordGenerator{
	
	private $length;
	private $chars;
	private $special;
	private $sourcecode;
	
	public function __construct(){
		/* Datei Quelltext */
		$this->sourcecode = DIR_PLUGIN.'PasswordGenerator/html/sourcecode.html';
		/* Default lenght */
		$this->length = 8;
		/* Default Specialchars */
		$this->special = "-+=_,!@$#*%<>{}";
	}
	
	public function viewHTML(){
		$html = '';
		if(file_exists($this->sourcecode)){
			$html = sprintf(file_get_contents($this->sourcecode), $_SERVER['REQUEST_URI'], $this->length, $this->special);
		}
		return $html;
	}
	
	public function getAjaxData($param = array()){
		if(isset($param['length']) and is_numeric($param['length']) and $param['length'] < 20 and $param['length'] > 4){
    		$this->length = $param['length'];
		}
		$this->setChars($param);
 		
		return $this->generatePassword($this->length, $this->chars);
	}
	
	private function getAlphabet($case){
		$alphabet = '';
		switch($case){
			case 'upper':
				$str = range('A', 'Z');
				break;
			case 'lower':
				$str = range('a', 'z');
				break;
		}
		foreach ($str as $char) {
    		$alphabet .= $char;
		}
		return $alphabet;
	}
	
	private function getNumbers($min, $max){
		$a = $min;
		$numbers = '';
		while($a <= $max){
			$numbers .= $a;
   			$a++;
   		}
		return $numbers;
	}
	
	private function getSpecialChars($chars){
		$pattern = '/[^'.$this->special.']+/';
		return preg_replace($pattern, '+', $chars);
	}
	
	private function setChars($arrChars){
		$this->chars = $this->getAlphabet('lower');
		if(!empty($arrChars['uppercase']) and $arrChars['uppercase'] == 'on'){
			$this->chars .= $this->getAlphabet('upper');
		}
		if(!empty($arrChars['numbers']) and $arrChars['numbers'] == 'on'){
			$this->chars .= $this->getNumbers(0, 9);
		}
		if(!empty($arrChars['special']) and $arrChars['special'] == 'on' and !empty($arrChars['specialchars'])){
			$this->chars .= $this->getSpecialChars($arrChars['specialchars']);
		}
	}
	
	private function generatePassword($length, $chars){
		/* Länge der Zeichenkette ermitteln */
		$max = strlen($chars);
		$password = '';
 
		for($i = 1; $i <= $length; $i++){
			/* Hole aus der Zeichenkette ein zufälliges Zeichen */
			$rand = mt_rand(0, $max-1);
        	$password .= substr($chars, $rand, 1);
		}
		/* Mischt das Passwort nach dem Zufallsprinzip */
		$password = str_shuffle($password);
		
		return $password;	
	}
}

?>