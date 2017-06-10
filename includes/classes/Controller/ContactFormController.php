<?php
    
 /**
 * Contactform Controller
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
 * Class ContactFormController
 * @package Controller
 */

class ContactFormController {
	
	/** Properties */
	public $userdata;
	public $entries;
    public $email;
	public $data = [
		'adress' => '',
		'name' => '',
		'content' => '',
		'subject' => ''
	];
    public $error = [
		'<p class="success">Daten gesendet</p>',
		'<p class="error">Fehler beim Senden!</p>',
        '<p class="error">Pflichtangaben fehlen!</p>'
    ];

	/**
	 * ContactFormController constructor.
	 */

	public function __construct(){
		$this->entries = new \Model\GetContent();
		$this->userdata = $this->entries->getSiteSettings();
        $this->fm = new \Model\FormModel();
	}
	
	/**
	 * Kontakt-Formular Controller
	 *
	 * *Description*
	 *
	 * @param array
	 *
	 * @return array
	 */
 
	public function sendMessage($request){
	
        $this->validFormContact($request);
		if(!empty($this->data)){
            $email = array(
                'to' => $this->userdata['email'],
                'content' => $this->CompileMessage($this->data, 'contact.txt')
            );
		    $this->email = array_merge($this->data, $email);
		    
		    if($this->fm->sendContactData($this->email)){
			    return $this->error[0];
		    }
		    else{
			    return $this->error[1];
		    }
        }
        else{
            return $this->error[2];
        }	
	}
	
	/**
	 * Kontakt-Formular validieren
	 *
	 * *Description*
	 *
	 * @param array
	 *
	 * @return array
	 */
 
	public function validFormContact($param){
		// clean send Data
		$send = \Controller\Helpers::Clean($param);
		
		// Required Content, Address, Subject ...
		foreach($this->data as $key => $value){
			if(array_key_exists($key, $send)){
				$this->data[$key] = !empty($send[$key]) ? $send[$key] : $key.' no specification';
			}
			else{
				break;
				$this->data = array();
			}
		}
		
	}	
	
	/**
	 * Inhalt der Nachricht kompilieren
	 *
	 * *Description*
	 *
	 * @param array, string
	 *
	 * @return string
	 */
 
	private function CompileMessage($values, $tplFile){
	
		//Prüfe auf korrekt übergenen Werte an die Funktion
		if(file_exists(PATH_MAIL_TPL.'/'.$tplFile)){

			// Textdatei zum Lesen in einen String
			$txt = file_get_contents(PATH_MAIL_TPL.'/'.$tplFile);
	
			// Such-Parameter (Platzhalter im Text)
			$arrSearch = array(
				'%FIRSTNAME%',
				'%LASTNAME%',
				'%MAINPAGE%',
				'%EMAIL%'
						);
						
			// Ersetzungs-Parameter (Variablen von außerhalb der Funktion)
			$arrReplace = array(
				$this->userdata['firstname'],
				$this->userdata['lastname'],
				'http://'.$_SERVER['HTTP_HOST'],
				$this->userdata['email']
						);
						
			//Übergebene Daten aus $values umschreiben und an den jeweiligen Array anhängen
            if(is_array($values)){
                foreach($values  as $k => $v){
                    if(is_numeric($k)){
                        $search = '%VALUE'.$k.'%';
                    }
                    else{
                        $search = '%'.strtoupper($k).'%';
                    }
                    array_push($arrSearch, $search);
                    array_push($arrReplace, $v);                    
                }
            }
            else{
                array_push($arrSearch, "%VALUE%");
                array_push($arrReplace, $values);
            }
				
			// Suchen & Ersetzen im Mail-Text
			$mailTxt = str_replace($arrSearch, $arrReplace, $txt);	            
		}
		return $mailTxt; 	
	}
}

?>