<?php
    
 /**
 * Create Menues
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 
 namespace View; 


class Menu {
	
	public $arr_nav;
	public $pages;
	
	public function __construct() {
	
		$this->arr_nav = new \Controller\NavController();
		$this->pages = $this->arr_nav->entries;
	}
	
	public function Navigation($class = array()){
		
		$_class = array_shift($class);
		$css = !empty($_class) ? ' class="'.$_class.'"' : '';
		$menu = "\n\t\t\t<ul".$css.">\n";
		$menu .= $this->buildMenu($this->arr_nav->arrNavigation());
		$menu .= "\t\t\t</ul>";
		return $menu;
	}
	
	public function Breadcrumb(){
		
	}
	
	public function SingleLink($page, $anchortxt = 'Warning: Specify Anchor Text!'){
		
		$site = array_shift($page);
		$arr_entries = $this->pages->getEntry($site);
		$title = '';
		if($this->arr_nav->checkSite($site)){
			$url = \Controller\Helpers::buildLink($site);
			if(!empty($arr_entries['anchor'])){
				$anchortxt = $arr_entries['anchor'];
				$title = ' title="'.$arr_entries['title'].'"';
			}
			elseif(!empty($page)){
				$anchortxt = $page[0];
			}
		}
		else{
			$url =  '#';
		}
		$link ='<a href="'.$url.'"'.$title.'>'.$anchortxt.'</a>';
		return $link;
	}
	
	private final function buildMenu($menuArray){
		$list = '';
		foreach ($menuArray as $node)
		{
			if($node['page'] == \Controller\Helpers::getGlobals('Page')){
				$activ = ' class="activ"';
			}
			else {
				$activ = '';
			}
			$list .= "\n\t\t\t\t<li>\n\t\t\t\t\t".'<a href="'.\Controller\Helpers::buildLink($node['page']).'" title="'.$node['title'].'"'.$activ.'>'.$node['anchor']."</a>\n";
			if (!empty($node['children'])) {
				$list .= "\n\t\t\t\t<ul>\n";
				$list .= $this->buildMenu($node['children']);
				$list .= "\t\t\t\t</ul>\n";
			}
			$list .= "\t\t\t\t</li>\n";
		}
		
		return $list;
	} 
}

?>