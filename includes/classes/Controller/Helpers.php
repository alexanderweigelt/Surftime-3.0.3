<?php
    
 /**
 * Validation and Helpers
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Controller;
 

class Helpers {
	
/**
 * Eingaben bereinigen
 *
 * *Description* Schutz vor XSS Attacken, MySQL-Injection
 * 
 * @param array
 *
 * @return array
 */ 
 
  	public static function Clean($value) {
    
		if(is_array($value)) 
		{
			foreach ($value as $key => $input_arr) 
			{
				$input_arr = strip_tags($input_arr);
				$input_arr = htmlspecialchars($input_arr);
				// Eingaben von Anfuehrungszeichen bereinigen
				if (!get_magic_quotes_gpc())
				{
					$input_arr = addslashes($input_arr);
				}
				$value[$key] = $input_arr;
			}        
		} 
		else
		{
			$value = strip_tags($value);
			$value = htmlspecialchars($value);
			if (!get_magic_quotes_gpc())
			{
				$value = addslashes($value);
			}
		}
	return $value;
  	}
		
/**
 * Konvertieren Bytes in Bit
 *
 * *Description* 
 * 
 * @param string
 *
 * @return int
 */
 
	public static function convertBytes($value) {
        if (is_numeric($value)){
            return $value;
        } else {
            $value_length = strlen( $value );
            $qty = substr( $value, 0, $value_length - 1 );
            $unit = strtolower( substr( $value, $value_length - 1 ) );
            switch ( $unit ) {
                case 'k':
                    $qty *= 1024;
                    break;
                case 'm':
                    $qty *= 1048576;
                    break;
                case 'g':
                    $qty *= 1073741824;
                    break;
            }
            return $qty;
        }
    }
	
/**
 * Maximale groesse Upload ermitteln
 *
 * *Description* 
 * 
 * @param int
 *
 * @return int
 */
 
    public static function maxSize($number = null){
        $max_size = self::convertBytes(ini_get('upload_max_filesize'));
        if(!empty($number)){
            return round($max_size / $number);
        }
        return $max_size;
    }
		
/**
 * Korrekten Pfad bilden
 *
 * *Description* 
 * 
 * @param string
 *
 * @return string
 */
 
	public static function buildLink($page){
		
		if(!URL_REWRITING){
			$p = 'index.php?site='.$page;
		}
		else{
			$p = $page.'.'.EXTENSION;
		}
		$link = self::getHost().SITEPATH.$p;
		return $link;
	}
		
/**
 * Korrekte URI Host bilden
 *
 * *Description* 
 * 
 * @param 
 *
 * @return string
 */
 
	public static function getHost(){
    
		if(isset($_SERVER['HTTPS']) or $_SERVER['SERVER_PORT'] == 443){
			$tp = 'https://';
		} 
		else{
			$tp = 'http://';
		}
	
		$url = $tp.$_SERVER['HTTP_HOST'];
	
		return $url;    
	}
		
/**
 * Dateinamen bilden
 *
 * *Description* 
 * 
 * @param string
 *
 * @return string
 */
 
	public static function buildLinkName($text = '') {
		
		// Leerzeichen entfernen
		$text = trim($text);		
		// Aendern der Umlaute fuer die Dateinamen	
        $text = str_replace( 'ä', 'ae', $text );
        $text = str_replace( 'ö', 'oe', $text );
        $text = str_replace( 'ü', 'ue', $text );
        $text = str_replace( 'Ä', 'ae', $text );
        $text = str_replace( 'Ö', 'oe', $text );
        $text = str_replace( 'Ü', 'ue', $text );
        $text = str_replace( 'ß', 'ss', $text );
        $text = str_replace( '_', '-', $text );
        $text = str_replace( '/', '', $text );
        // remove special characters
        $text = preg_replace( '/[^A-z0-9]/', '-', $text );
		// Dateiname immer klein schreiben
		$text = strtolower($text);
		
        return $text;
	}
		
/**
 * Pager 
 *
 * *Description* 
 * 
 * @param array, string, int
 *
 * @return array
 */
 
	public static function paganation($input, $page, $limit){
		
		//Setting
		$show_per_page = is_integer($limit) ? $limit : 10;
		$page = is_integer($page) ? $page : 0;
		$output = array();
		
		if(is_array($input)){
			$start = $page * $show_per_page;
			$end = $start + $show_per_page;
			$count = count($input);
		
			// Conditionally return results
			if($start < 0 or $count <= $start){
				// Page is out of range
				$output = $input; 
			}
			elseif($count <= $end){ 
				// Partially-filled page
				$output = array_slice($input, $start);
			}
			else{
				// Full page 
				$output = array_slice($input, $start, $end - $start);
			}		
		}
		return $output;
	}
		
/**
 * Datumsformat umwandeln
 *
 * *Description* 
 * 
 * @param string
 *
 * @return string
 */
 
	public static function dateMySQL2German($date) {
		// datumsausgabe date datenbank
		$d    =    explode("-",$date);
		return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
	}
		
/**
 * Datumsformat umwandeln
 *
 * *Description* 
 * 
 * @param string
 *
 * @return string
 */
 
	public static function timestampMySQL2German($date){
        setlocale (LC_TIME, "de_DE");
        $timestamp = strtotime($date);
        return  strftime("%a, %d %b %Y %H:%M:%S",$timestamp);
	}
		
/**
 * E-mail checker
 *
 * *Description* 
 * 
 * @param string
 *
 * @return boolean
 */

	public static function checkEmail($strEmail) {
			// is mail is not set, return false
			if(!isset($strEmail))
			{
					return false;
			}
			// regular expression
			$regex = '/^[\w.!#%&\*\/=\?\^\`\{\|\}\~+-]{1,64}\@ [[:alnum:].-]{1,255}\.[a-z]{2,9}$/xi';
			if(!preg_match($regex,$strEmail))
			{
					return false;
			}
			// if no error
			return true;
	}
		
/**
 * Pfad zu Wurzelverzeichnis
 *
 * *Description* 
 * 
 * @param 
 *
 * @return string
 */
 
	public static function pathToRoot() {
		$tmp = dirname($_SERVER['PHP_SELF']);
		$tmp = str_replace('\\', '/', $tmp);
		$tmp = explode('/', $tmp);
	
		$relpath = NULL;        
		for ($i = 0; $i < count($tmp); $i++) {
			if ($tmp[$i] != '') 
				$relpath .= '../';
		}
	
		if ($relpath != NULL)
			// remove trailing slash
			$relpath = substr($relpath, 0, -1);
		else
			// return a dot so we can add a slash later on
			$relpath = '.';
	
		return $relpath;
	}

/**
 * Globale Variable setzen
 *
 * *Description* Setzt eine globale Variable
 * 
 * @param string, string
 *
 * @return string
 */
 	
	static public function setGlobals($name, $value){
        $GLOBALS[$name] = $value;
    }

/**
 * Globale Variable auslesen
 *
 * *Description* Liest eine globale Variable aus und gibt im Fehlerfall false zurück.
 * 
 * @param string
 *
 * @return string, array, boolean
 */
 
    static public function getGlobals($name){
		if(!empty($GLOBALS[$name])){
        	return $GLOBALS[$name];
		}
		else{
			return FALSE;
		}
    }

/**
 * Passwort verschlüsseln
 *
 * *Description* Gibt einen Hash-String zurück, der unter Verwendung des DES-basierenden Unix-Standard-Hashingalgorithmus oder einem anderen auf ihrem System verfügbaren Algorithmus erstellt wurde. 
 * 
 * @param string
 *
 * @return string, boolean
 */	
	
	static public function encryptPassword($password = NULL){
		if(!empty($password) and is_string($password)){
			$salt = '$2a$13$'.substr(sha1(uniqid()), 10, 22);
			return crypt($password, $salt);
		}
		else{
			return FALSE;
		}
	}
}

?>