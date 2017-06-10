<?php
    
 /**
 * Action Formular Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace Model;
use Controller\Helpers;


/**
 * Class FormModel
 * @package Model
 */

class FormModel {
	
	/**
	 * Send E-Mail
	 *
	 * *Description*
	 *
	 * @param array
	 *
	 * @return boolean
	 */
 
	public function sendContactData($email){
		$mail = new \Framework\Mail();
		$mail->setTo($email['to']);
		$mail->setSubject($email['subject']);
		$mail->setMessage($email['content']);
		$mail->setReplyTo($email['adress']);
		$mail->setFrom('noreply@'.$_SERVER['HTTP_HOST'], '* Formularmailer '.Helpers::getHost().' *');

		// send message
		if($mail->send()){
			return true;
		}
		else{
			return false;
		}
	}
	
	
}

?>