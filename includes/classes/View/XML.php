<?php
    
 /**
 * XML View
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 
 namespace View; 


class XML {
	
	public $xmlHeader;
	
	public function __construct($charset) {
		//XML Header ausgeben
    	$this->xmlHeader = '<?xml version="1.0" encoding="'.$charset.'" ?>';	
	}
	
	public function sitemap($pages){
		$sitemap = $this->xmlHeader;
		$sitemap.= "
	<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" 
	xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" 
	xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
			";
		// Content start here
		foreach($pages as $page){
			if($page['indexation'] == 'index'){
				$sitemap .= '
		<url>
			<loc>'.\Controller\Helpers::buildLink($page['page']).'</loc>
      		<lastmod>'.$page['created'].'</lastmod>
      		<changefreq>monthly</changefreq>
   		</url>
				';
			}
		}
		
		$sitemap.= "
	</urlset>\n";	
		
		return $sitemap;
	}
	
	public function defaultXML($msg = ''){
		$xmlcont = $this->xmlHeader."\n";
		//Fehlermeldung ausgeben
        $xmlcont.= '<!DOCTYPE  Content [
	<!ELEMENT Content (Caption,Text*)>
	<!ELEMENT Caption (#PCDATA) >
	<!ELEMENT Text (#PCDATA) >
]>

	<Content>
		<Caption>Document Error</Caption>
		<Text>
			 '.$msg.'       
		</Text>
	</Content>';
		
		return $xmlcont;		
	}
	
}