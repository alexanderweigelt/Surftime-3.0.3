<?php
    
 /**
 * File Upload Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;


class FileUpload {
	
	/** Settings Whitelist; zugelassene Dateiendungen */
	private $whitelist = array('jpg','png','gif','txt','csv','pdf');
	
	/** Eigenschaften definieren */
	public $code;
	public $success;
	private $files = array();
	public $destination_path;
	
/**
 * Konstruktor 
 *
 * *Description* Temporaeres Verzeichnis fuer Upload erstellen
 * 
 * @param string
 *
 * @return 
 */
 
	public function __construct($path = ''){
		$this->code = substr(strtoupper(md5(microtime())), 0, 20);
		$this->success = array('error' => false, 'message' => '', 'dirname' => $this->code);
		
		//Zielverzeichnis erstellen
		$this->destination_path = $path.$this->code;
		if(file_exists($path)){
			if(!mkdir($this->destination_path, 0755)){
				die('Create the directories '.$this->destination_path.'/ failed ...');
			}
		}
		else{
			if(!mkdir($this->destination_path, 0755, true)){
				die('Create the directories recursiv '.$this->destination_path.'/ failed ...');
			}
		}
	}
	
/**
 * Upload validieren 
 *
 * *Description* 
 * 
 * @param array
 *
 * @return array
 */
 
	public function getFile($upload = array()){
		if(!empty($upload) and is_array($upload)){
			$i = 0;		
			foreach($upload as $value){	
				if(array_key_exists('error', $value) and !$value['error']){
					$path_parts = pathinfo($value['name']);
					$num = $i + 1;
					$files[$i] = array(
						'source' => $value['tmp_name'],
						'extension' => $path_parts['extension'],
						'filename' => 'FILE_'.sprintf("%02d",$num)
					);
				}
				else{
					$files[$i] = array(
						'source' => '',
						'extension' => '',
						'filename' => ''
					);
				}
				$i++;
			}
		}
		else{
			$files[0] = array(
				'source' => '',
				'extension' => '',
				'filename' => ''
			);	
		}
		return $files;		
	}

/**
 * Eigentlicher Upload
 *
 * *Description* 
 * 
 * @param array
 *
 * @return array
 */
 
	public function upload($data = null){
		
		if(!empty($data)){
			//Hole Datenarray
			$files = $this->getFile($data);
			$i = 1;

			// upload file
			foreach($files as $file){				
				if(in_array($file['extension'], $this->whitelist)){
					//Upload start
					$target = $this->destination_path.'/'.$file['filename'].'.'.$file['extension'];
					if (move_uploaded_file($file['source'], $target)) {
						$this->success['message'] .= "Successfully uploaded <em>$target</em>.<br>\n";
						$this->success['error'] = FALSE;
					}
					else {
						//Fehlermeldungen ausgeben
						$this->success['message'] .= "Error uploading <em>$target</em>.<br>\n";
					}
				}
				else {
					$this->success['message'] .= "Filename cannot be empty in <em>Upload $i</em>.<br>\n";
				}
				$i++;
			}
			//endforeach
		}
		else{
			$this->success['message'] = "Error! Files Array is incorrect.";
		}
		return $this->success;
	}
}
?>