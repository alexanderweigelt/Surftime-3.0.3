<?php
    
 /**
 * Save Images Model
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class ImageModel {
	
	/** Konstanten zur Erstellung Vorschaubild (Thumbnail) */
	const HEIGHT_THUMB = 180;
	const FORMAT = '1x1'; // Formatangabe des Thumbnail breite x höhe
	
	/** maximale Bildgröße setzen  */
	const MAX_HEIGHT_BIG = 400;
	const MAX_WIDTH_BIG = 533;
	
	/** Eigenschaften definieren */
	private $format_x;
	private $format_y;
	public $settings;
	
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
		$format = explode('x', self::FORMAT);
		$this->format_x = trim($format[0]);
		$this->format_y = trim($format[1]);
	}
	
/**
 * Bilder bearbeiten und speichern
 *
 * *Description* 
 * 
 * @param string, string, string
 *
 * @return boolean
 */
 
	public function createImage($path_tmp, $img_name, $type = 'big'){
		
		$createimage = FALSE;
		
		// Prüfen ob der übergeben Pfad korrekt ist
		if(file_exists($path_tmp))
		{
			/* ------------- Bilderstellung ------------- */
			
			//Bildgröße des Original bestimmen
			$arr_image_size = getimagesize($path_tmp);
			$src_w = $arr_image_size[0];
			$src_h = $arr_image_size[1];
			$imgtype = $arr_image_size[2];
			
			// Bildgröße des neuen Bild berechnen
			if($type == 'thumb'){
				// Behandlung des Thumbnails
        		$directory = DIR_IMAGES_THUMBNAILS;
				// Neue Höhe und Breite ermitteln
				$dst_h = self::HEIGHT_THUMB;
				$dst_w = floor($this->format_x * self::HEIGHT_THUMB / $this->format_y);
			}
			else{
				// Behandlung der übrigen Bilder
        		$directory = DIR_IMAGES_BIG;
				$max_w = !empty($this->settings['maxwidth']) ? $this->settings['maxwidth'] : self::MAX_WIDTH_BIG;
				$max_h = !empty($this->settings['maxheight']) ? $this->settings['maxheight'] : self::MAX_HEIGHT_BIG;
				// Neue Höhe und Breite im Verhältnis ermitteln
				if($src_h >= $src_w and $src_h > $max_h){
					$dst_h = $max_h;
					$dst_w = floor($max_h * $src_w / $src_h);
				}
				elseif($src_w > $src_h and $src_w > $max_w){
					$dst_w = $max_w;
					$dst_h = floor($max_w * $src_h / $src_w);
				}
				else{
					$dst_w = $src_w;
					$dst_h = $src_h;
				}
			}
			
			// Zielbild
			$dst_image = imagecreatetruecolor($dst_w, $dst_h);

			// Quellbild
			switch ($imgtype) {
		
			case IMAGETYPE_JPEG:
				// JPEG
				$src_image = imagecreatefromjpeg($path_tmp);
				$filename = \Controller\Helpers::buildLinkName($img_name).'.jpg';
				break;
			case IMAGETYPE_PNG:
				// PNG
				$src_image = imagecreatefrompng($path_tmp);
				$this->setTransparency($dst_image, $src_image);
				$filename = \Controller\Helpers::buildLinkName($img_name).'.png';
				break;
			case IMAGETYPE_GIF:
				// GIF
				$src_image = imagecreatefromgif($path_tmp);
				$this->setTransparency($dst_image, $src_image);
				$filename = \Controller\Helpers::buildLinkName($img_name).'.gif';
				break;
			}
			
			
/*
******************************************
* $dst_image ist Resource des Zielbildes.
*
* $src_image ist Resource des Quellbildes.
*
* $dst_x ist x-coordinate vom Anfangspunkt.
*
* $dst_y ist y-coordinate vom Anfangspunkt. 
*
* $src_x ist x-coordinate vom Anfangspunkt. 
*
* $src_y ist y-coordinate vom Anfangspunkt.
*
* $dst_w ist Ziel breite.
*
* $dst_h ist Ziel höhe.
*
* $src_w ist Breite der Quelle.
*
* $src_h ist Höhe der Quelle.
******************************************
*/
			//Strings aus Array der berechneten Koordinaten
			foreach($this->calcSize($src_w, $src_h, $dst_w, $dst_h) as $key => $value){
				$key = trim($key);
				$$key = $value;
			}
			
			// Eigentliche Erstellung des neuen Bildes
			imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );

			/* ------------- Copyright ------------- */

			

			/* ------------- Bildspeicherung ------------- */

			// Zielbild
			switch ($imgtype) {
		
			case IMAGETYPE_JPEG:
				// JPEG
				if(imagejpeg($dst_image, $directory.$filename, 95 )){ $createimage = TRUE;}			
				break;
			case IMAGETYPE_PNG:
				// PNG
				if(imagepng($dst_image, $directory.$filename)){ $createimage = TRUE;}	
				break;
			case IMAGETYPE_GIF:
				// GIF
				if(imagegif($dst_image, $directory.$filename)){ $createimage = TRUE;}	
				break;
			}

			// Lösche tmp Bilder
			imagedestroy( $src_image );
			imagedestroy( $dst_image );      
		}
		return $createimage;
	}
	
/**
 * Bildergroesse berechnen
 *
 * *Description* 
 * 
 * @param int, int, int, int
 *
 * @return array
 */
 
	private function calcSize($src_w, $src_h, $dst_w, $dst_h){
		
		$coords = array(
			'dst_h' => $dst_h,
			'dst_w' => $dst_w,
			'dst_x' => 0,
			'dst_y' => 0,
			'src_x' => 0,
			'src_y' => 0
		);

		/* ------------- Berechnungen ------------- */
		
		// Seitenverhälnisse berechnen
		$new_dst_w = floor($dst_h * $src_w / $src_h);
		$new_dst_h = floor($dst_w * $src_h / $src_w);
		$ratio['src'] = $src_w / $src_h;
		$ratio['dst'] = $dst_w / $dst_h;
		
		// wenn Zielbild mit Breite größer als Höhe
		// und Quellbild mit Breite kleiner als Höhe
		if ( $ratio['dst'] < $ratio['src'] ){
			$coords['dst_x'] = floor( $dst_w / 2 - $new_dst_w / 2 );
			$coords['dst_w'] = $new_dst_w;
		}
		// wenn neues Bild mit Höhe größer als Breite
		// und Quellbild mit Breite größer als Höhe
		elseif( $ratio['dst'] > $ratio['src'] ){
			$coords['dst_y'] = floor( $dst_h / 2 - $new_dst_h / 2 );
			$coords['dst_h'] = $new_dst_h;
		}
		
		return $coords;		
	}
	
/**
 * Bilder entfernen/loeschen
 *
 * *Description* 
 * 
 * @param string
 *
 * @return 
 */
 
	public function removeImage($path){
		if(file_exists($path)){
			unlink($path);
		}
	}

/**
 * Transparente PNG
 *
 * *Description* Setzt die Transparaez beim Resize von PNG und GIF Images
 * 
 * @param string
 *
 * @return 
 */
 	
	public function setTransparency($new_image, $image_source) { 
        
		$transparencyIndex = imagecolortransparent($image_source); 
		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
					 
		if ($transparencyIndex >= 0) { 
			$transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);    
		} 
					
		$transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
		imagefill($new_image, 0, 0, $transparencyIndex); 
		imagecolortransparent($new_image, $transparencyIndex); 
        
    } 
}

?>