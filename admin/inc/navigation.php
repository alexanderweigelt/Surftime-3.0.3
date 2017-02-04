<?php
    
 /**
 * Admin Include Navigation
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */


if(defined('DIR_PROTECTION') and DIR_PROTECTION){

		print('
			<nav class="top-bar" data-topbar role="navigation"> 
				<ul class="title-area"> 
					<li class="name"> <h1><a href="'.DIR.'"><i class="fi-home"></i> Start</a></h1> </li> 
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone --> 
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li> 
				</ul> 
				
				<section class="top-bar-section"> 	
					<!-- Left Nav Section --> 
					<ul class="left"> 
						<li><a href="'.DIR.'?load=setting">Settings</a></li>
						<li><a href="'.DIR.'?load=help">Help</a></li> 
					</ul> 
					<!-- Right Nav Section --> 
					<ul class="right"> 
						<li class="active"><a href="'.DIR.'?action=logout"><i class="fi-power"></i> Logout</a></li> 
					</ul>
				</section> 
			</nav>
		');	
	
}
?>