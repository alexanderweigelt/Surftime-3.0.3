<?php
    
 /**
 * Admin Single Page - Plugin Management
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */


if(defined('DIR_PROTECTION') and DIR_PROTECTION){
	
	//Lade die Navigation der Seite
	require_once DIR_ADMIN.'inc/navigation.php';

	// Start Content here
	?>
	
					<div class="small-12 large-12 columns">
						<h2 class="subheader"><i class="fi-widget"></i> Edit Plugin</h2>
						<p>Bearbeite und verwalte deine Systemerweiterungen.</p>
	<?php
		//Return Plugin Management
		if($this->Data['PluginPath']){
			include_once($this->Data['PluginPath']);				
		}
		else{	
	?>
		
						<div class="panel">
							<p>Für dieses Plugin ist keine Administration vorgesehen.</p>
						</div>
	<?php	
		}
	?>
					</div>
	<?php
}
?>