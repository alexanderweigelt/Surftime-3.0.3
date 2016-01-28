<?php
    
 /**
 * Konfiguriere Einstellungen 
 *
 * *Description* Die Angaben für DB_NAME, DB_USER, DB_PASS, DB_HOST und 
 * INSTALL_PASS sollten generell angepasst werden. Alle anderen Angaben
 * sind optional. Danach speichere die Datei im gleichen Verzeichnis
 * unter config.inc.php
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 

/** Datenbankverbindung konfigurieren */

/**  Hinterlege statt database den Namen der Datenbank, die du verwenden willst */
define('DB_NAME', 'database');

/** Hinterlege statt username deinen MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'username');

/** Hinterlege statt password dein MySQL-Passwort */
define('DB_PASS', 'password');

/** Hinterlege statt localhost deine MySQL-Serveradresse */
define('DB_HOST', 'localhost');

/** Setze ein Tabellenpräfix um eventuell doppelt benannte Tabellen zu vermeiden. */
define('TBL_PRFX', 'pas_');

/** Hinterlege statt install_pass ein Passwort, mit dem du deine Installation starten kannst */
define('INSTALL_PASS', 'install_pass');

/** Suchmaschinenfreundliche Dateinamen aktivieren. Der Server muss .htaccess akzeptieren */
define('URL_REWRITING', FALSE);

/** Maximale Anzahl an Benutzern */
define('LIMIT_USER', 5);

/** Maximale Anzahl an möglichen Seiten */
define('LIMIT_PAGES', 50);

/** Fehlermeldungen anzeigen lassen. Standard ist FALSE für keine Ausgabe */
define('DEBUG_MODE', FALSE);

?>