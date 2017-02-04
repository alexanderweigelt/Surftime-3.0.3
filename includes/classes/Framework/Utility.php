<?php
    
 /**
 * Utility
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Framework;
 

class Utility {
	
	
	protected static $defaultTimeZone = 'Europe/Berlin';
	
	protected static $defaultCharset = 'UTF-8';
	
	public static $sysCharset = array(
			'ISO-8859-1' => 'latin1',
			'UTF-8' => 'utf8',
			'UTF-16' => 'utf16',
			'ASCII' => 'ascii',
		);
	
	public static function setCharset($charset = ''){
		if(!defined('SYS_CHARSET') and array_key_exists($charset, self::$sysCharset())){
			define('SYS_CHARSET', $charset);
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public static function getCharset($output = 0){
		if(defined('SYS_CHARSET') and array_key_exists(SYS_CHARSET, self::$sysCharset())){			
			$charset = array(SYS_CHARSET, self::$sysCharset[SYS_CHARSET]);
		}
		else{
			$charset = array(self::$defaultCharset, self::$sysCharset[self::$defaultCharset]);
		}
		$key = ($output === 0 or $output === 1) ? $output : 0;
		return $charset[$key];
	}
	
	public static function setTimezone($timeZone = ''){
		if(in_array($timeZone, \DateTimeZone::listIdentifiers())){
			$_timeZone = $timeZone;
		}
		else{
			$_timeZone = self::$defaultTimeZone;
		}
		// Sets the default timezone used by all date/time functions in a script
		date_default_timezone_set($_timeZone);
		return $_timeZone;
	}
	
	public static function getTimezone(){
		if (date_default_timezone_get()) {
    		return date_default_timezone_get();
		}
		else{
			return FALSE;
		}
	}
	
}

?>