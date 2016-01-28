<?php
    
 /**
 * Load Extensions Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class LoadExtensions {
	
	private static $plugin = array('head' => '', 'body' => '', 'library' => '');
	
/**
 * Plugin laden
 *
 * *Description* Pluginordner durchlaufen und valide Plugin includieren
 * 
 * @param 
 *
 * @return 
 */
 
	public static function PluginLoader(){
		foreach(glob(DIR_PLUGIN.'*/index.php') as $file){ 
			include_once($file);
		}	
	}
	
/**
 * Uebergebene Daten von Plugin
 *
 * *Description* Uebergebene Daten aus Aufruf Methode in Plugin. Verarbeite 
 * und diese auf jeder Seite im <head> oder am Ende des <body>
 * 
 * @param string, string
 *
 * @return 
 */
 
	public static function AddHTML($tag, $content){

		switch($tag){	
			case ('head'):
				self::$plugin['head'] .= "\n\t\t".$content;
			break;
			
			case ('body'):
				self::$plugin['body'] .= "\n\t\t".$content;
			break;
			
			case ('library'):
				self::$plugin['library'][$content] = TRUE;
			break;
		}
	}
	
/**
 * Inhalte aus Plugin zu Quelltext
 *
 * *Description* Fuege Meta oder Body Information von Plugins in geparsten Content der Seite ein
 * 
 * @param string
 *
 * @return string
 */
 
	public static function AddPlugin($html){
        $add_meta = self::AddMeta();
        $add_body = self::AddBody();
        if(!empty($add_meta) or !empty($add_body)){
            return str_replace(array('</head>', '</body>'), array(self::AddMeta(), self::AddBody()), $html);
        }
		else{
		    return $html;
		}
	}
	
	private static function AddMeta(){
		return self::MergeLibraries()."\n".self::$plugin['head']."\n".'</head>';
	}
	
	private static function AddBody(){
		return self::$plugin['body']."\n".'</body>';
	}
	
	private static function AddLibs($name = ''){
		if(method_exists('\View\Library', $name)){
			$libraries = new \View\Library();
			return $libraries->$name();
		}
		else{
			return '<!-- Library '.$name.'  is missing... --> ';
		}
	}

	private function MergeLibraries(){
		$content = '';
		foreach(self::$plugin['library'] as $library => $set){
			$content = self::AddLibs($library);
		}
		return $content;
	}
}

?>