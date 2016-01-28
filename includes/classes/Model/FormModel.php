<?php
    
 /**
 * Action Formular Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;


class FormModel {
	
/**
 * E-Mail senden
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function sendContactData($email){
		
		// bulid header
		$headers  = 'From:* Formularmailer '.$_SERVER['HTTP_HOST'].' *<noreply@'.$_SERVER['HTTP_HOST'].'>'."\n";
		$headers .= 'Reply-To:'.$email['adress']."\n";
		$headers .= 'X-Mailer: PHP'."\n";
		$headers .= 'Content-Transfer-Encoding: 8bit'."\n";
		$headers .= 'MIME-Version: 1.0'."\n";
		$headers .= 'Content-type: text/plain; charset=UTF-8'."\n";

		// send message
		if(mail($email['to'], $email['subject'], $email['content'], $headers)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
}

?>