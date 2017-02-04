<?php
    
 /**
 * Autoload Function and Classes
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 


/**
 * Load all Functions
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
foreach(glob(FUNCTIONS_PATH.'*.php') as $include) {   
	include_once($include);    
}

/**
 * Load all Classes
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */

if(defined('PHP_VERSION') and version_compare(PHP_VERSION, '5.5.0') >= 0) {
	
	//Klassen beim instanziieren aus Ordnern laden  
	spl_autoload_register( function ($Class) {
		$className = ltrim($Class, '\\');
		$fileName  = __DIR__.DIRECTORY_SEPARATOR;
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		
		if (function_exists('stream_resolve_include_path')) {
            $path = stream_resolve_include_path($fileName);
        } else {
            $path = false;
            foreach(explode(PATH_SEPARATOR, get_include_path()) as $p) {
                $fullname = $p.DIRECTORY_SEPARATOR.$fileName;
                if(is_file($fullname)) {
                    $path = $fullname;
                    break;
                }
            }
        }
        
        if ($path !== false) {
            include_once($fileName);
        }
		else{
		    //Fehler
			$message = 'Class <strong>'.$Class.'</strong> not found on : '.$fileName;
			$html = errorMessage($message);
            exit($html);
        }
	});
}
else {
	//Fehler
	$message = 'At least PHP 5. 5. 0 is assumed. The topical version PHP is '.phpversion();
    $html = errorMessage($message);
    exit($html);
}

?>