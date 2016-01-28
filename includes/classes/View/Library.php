<?php
    
 /**
 * Load Library
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace View;


class Library {
	
	/** Eigenschaften definieren */
	public $libraries;

/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
	
	public function __construct() {
		$this->libraries = new \Controller\LibraryController();
	}

/**
 * Bibliothek jQuery laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek jQuery an Controller übergeben
 * Pfad zur Datei im Template ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function jQuery(){
		$jQuery = '';
		$pathLibrary = $this->libraries->addLibrary('jQuery');
		if(!empty($pathLibrary)){
			$jQuery .= "\n\t".'<!-- Add Library jQuery -->';
			foreach($pathLibrary as $path){
				$jQuery.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
			}
		}
		return $jQuery;
	}
	
/**
 * Bibliothek jQueryUI laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek jQueryUI an Controller übergeben
 * Pfad zur Datei im Template <head> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function jQueryUI(){
		$jQueryUI = '';
		$pathLibrary = $this->libraries->addLibrary('jQueryUI');
		if(!empty($pathLibrary)){
			$jQueryUI .= $this->jQuery()."\n";
			$jQueryUI .= "\n\t".'<!-- Add Library jQueryUI -->';
			foreach($pathLibrary as $path){
				$path_parts = pathinfo(preg_replace('"\.gz$"', "", $path));
				switch ($path_parts['extension']) {
    				case 'js':
						$jQueryUI.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
					break;
					case 'css':
						$jQueryUI.= "\n\t".'<link rel="stylesheet" href="'.$path.'" />';
					break;
				}
			}
		}
		return $jQueryUI;
	}	

/**
 * Bibliothek Normalize laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek Normalize CSS an Controller übergeben
 * Pfad zur Datei im Template <head> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function Normalize(){
		$Normalize = '';
		$pathLibrary = $this->libraries->addLibrary('Normalize');
		if(!empty($pathLibrary)){
			$Normalize .= "\n\t".'<!-- Add Library Normalize -->';
			foreach($pathLibrary as $path){
				$Normalize.= "\n\t".'<link rel="stylesheet" href="'.$path.'" />';
			}
		}
		return $Normalize;
	}	

/**
 * Bibliothek Modernizr laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek Modernizr an Controller übergeben
 * Pfad zur Datei im Template <head> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function Modernizr(){
		$Modernizr = '';
		$pathLibrary = $this->libraries->addLibrary('Modernizr');
		if(!empty($pathLibrary)){
			$Modernizr .= "\n\t".'<!-- Add Library Modernizr -->';
			foreach($pathLibrary as $path){
				$Modernizr.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
			}
		}
		return $Modernizr;
	}
	
/**
 * Bibliothek Foundation CSS laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek Foundation an Controller übergeben
 * Pfad zur Datei im Template <head> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function Foundation(){
		$Foundation = '';
		$pathLibrary = $this->libraries->addLibrary('Foundation');
		if(!empty($pathLibrary)){
			$Foundation .= $this->Normalize()."\n";
			$Foundation .= "\n\t".'<!-- Add Library Foundation -->';
			foreach($pathLibrary as $path){
				$path_parts = pathinfo(preg_replace('"\.gz$"', "", $path));
				switch ($path_parts['extension']) {
    				case 'js':
						$Foundation.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
					break;
					case 'css':
						$Foundation.= "\n\t".'<link rel="stylesheet" href="'.$path.'" />';
					break;
				}
			}
			$Foundation .= "\n".$this->Modernizr()."\n";
		}
		return $Foundation;
	}	
	
/**
 * Bibliothek Foundation Javascript laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek Foundation Javascript an Controller übergeben
 * Pfad zur Datei im Template vor dem schließenden <body> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function FoundationJS(){
		$FoundationJS = '';
		$pathLibrary = $this->libraries->addLibrary('FoundationJS');
		if(!empty($pathLibrary)){
			//$FoundationJS .= $this->jQuery()."\n";
			$FoundationJS .= "\n\t".'<!-- Add Library Foundation Javascript -->';
			foreach($pathLibrary as $path){
				$FoundationJS.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
			}
			$FoundationJS .= "\n\t".'<script>$(document).foundation(\'\');</script>'."\n";
		}
		return $FoundationJS;
	}	

/**
 * Bibliothek Lightbox laden
 *
 * *Description* Aufruf zum öffnen der Bibliothek Lightbox an Controller übergeben
 * Pfad zur Datei im Template <head> ausgeben.
 * 
 * @param 
 *
 * @return string
 */
 	
	public function Lightbox(){
		$Lightbox = '';
		$pathLibrary = $this->libraries->addLibrary('Lightbox');
		if(!empty($pathLibrary)){
			$Lightbox .= $this->jQuery()."\n";
			$Lightbox .= "\n\t".'<!-- Add Library Lightbox -->';
			foreach($pathLibrary as $path){
				$path_parts = pathinfo(preg_replace('"\.gz$"', "", $path));
				switch ($path_parts['extension']) {
    				case 'js':
						$Lightbox.= "\n\t".'<script src="'.$path.'" type="text/javascript"></script>';
					break;
					case 'css':
						$Lightbox.= "\n\t".'<link rel="stylesheet" href="'.$path.'" />';
					break;
				}
			}
			$Lightbox.= "\n";
		}
		return $Lightbox;
	}	
}

?>