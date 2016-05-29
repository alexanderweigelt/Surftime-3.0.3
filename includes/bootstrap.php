<?php
    
 /**
 * Bootstrap 
 *
 * *Description* Definiere Pfade
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 


define('PROJECT_ROOT', './');
define('DIR', $_SERVER['PHP_SELF']);
define('EXTENSION', 'html');
define('MAINPAGE', 'index');
/** Administratorbereich */
define('DIR_ADMIN',PROJECT_ROOT.'admin/');

/**
 * System Pfade bzw. Ordner
 *
 * *Description* 
 */

/** Pfade MVC-Pattern, Funktionen und Bibliothek */
define('FUNCTIONS_PATH', PROJECT_ROOT.'includes/function/');
define('CLASSES_PATH', PROJECT_ROOT.'includes/classes/');
define('SYSTEM_FILES', PROJECT_ROOT.'includes/system/');
define('LIBS_PATH', PROJECT_ROOT.'includes/library/');

/** User Konfigurationsdatei */
define('CONFIG', PROJECT_ROOT.'config.inc.php');

/** Ordner Templates */
define('THEME_DIR', PROJECT_ROOT.'public/templates/');
define('THEME_DEFAULT', 'Default');

/** Ordner Vorlagen E-Mail */
define('PATH_MAIL_TPL', PROJECT_ROOT.'public/mail/');

/** Ordner Plugin */
define('DIR_PLUGIN',PROJECT_ROOT.'public/plugin/');

/**
 * Statische Seiten & Inhalte
 *
 * *Description* 
 */

define('PATH_PAGES', PROJECT_ROOT.'public/pages/');
/** HTML-Inhalt projektspezifische Fehlerseite */
define('ERRORPAGE','error.html');
/** HTML-Inhalt projektspezifische Installationsseite */
define('INSTALLPAGE','install.html');
/** HTML-Inhalt projektspezifische Installationsseite */
define('MAINTENANCE','maintenance.html');
/** HTML-Inhalt Kontaktformular */ 
define('CONTACTFORM','contact.html'); 
/** HTML-Inhalt Suchformular */
define('SEARCHFORM','search.html'); 

/**
 * Pfade Upload-Ordner und Bilder
 *
 * *Description* 
 */
 
/** Ordner in dem die Original Bilder temporär abgelegt werden */
define('DIR_IMAGES_TEMP', PROJECT_ROOT.'public/uploads/Temp/');
/** Ordner in dem die Thumbnails abgelegt werden */
define('DIR_IMAGES_THUMBNAILS', PROJECT_ROOT.'public/uploads/Thumbs/');
/** Ordner in dem die groesseren Bilder abgelegt werden */
define('DIR_IMAGES_BIG', PROJECT_ROOT.'public/uploads/Big/');

/**
 * Include config.inc.php
 *
 * *Description* Benutzer Konfigurationsdatei laden
 */
 		
if(file_exists(CONFIG)){
	include (CONFIG);
}
else{
	//Fehler
	$message = 'File: '.CONFIG.' not found ';
    include_once (FUNCTIONS_PATH.'errorMessage.php');
    $html = errorMessage($message);
    exit($html);
}

/**
 * Start Autoloader
 *
 * *Description* Alle Funktionen aus Ordner laden
 */

include CLASSES_PATH.'autoloader.php';

/**
 * Define Sitepath
 *
 * *Description* Kann ggf. entfern werden. Achtung wird noch im System verwendet!!!
 * Konstante vorher im Script entfernen oder erstetzen...
 */

define('SITEPATH', sitepath());

?>