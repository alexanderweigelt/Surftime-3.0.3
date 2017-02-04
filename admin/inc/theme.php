<?php
    
 /**
 * Admin Include Choose Theme
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */


if(defined('DIR_PROTECTION') and DIR_PROTECTION){

	// Start Content here
	?>
	
					<h2 class="subheader"><i class="fi-layout"></i> Choose Your Theme</h2>
					<p>Setze und bearbeite das Aussehen deiner Website, indem du ein Layout wählst.</p>
					<?php
					switch($this->Data['userRole']):
					case 'admin': 
					if(!empty($this->Data['Success']['Template'])){
						echo $this->Data['Success']['Template']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Template']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Template']['message'].'<a href="#" class="close">&times;</a></div>';
					}
					?>
					<div class="formTheme">	
						<form action="<?php echo DIR; ?>?load=setting&amp;action=choose" method="post">
							<label for="select">Template List</label>
							<div class="row collapse">
								<div class="small-12 large-8 columns">	
									
									<select id="select" name="theme[select]">
										<option value="">-</option>
						<?php 
						foreach($this->Data['Template'] as $templates){
							if($templates['activ']){
								$selected = ' selected';
							}
							else{
								$selected = '';
							}
							echo '
										<option value="'.$templates['file'].'"'.$selected.'>'.$templates['name'].'</option>';
						}
						?> 
									</select>
								</div>
								<div class="small-12 large-4 columns">
									<input type="submit" name="chooseTheme" value="setzen" class="button postfix">
								</div>
							</div>	
						</form>
					</div>
					<a href="#" data-reveal-id="myModal">+ see all Templates</a>
					<div id="myModal" class="reveal-modal" data-reveal>
						<h3 class="subheader">Alle verfügbaren Vorlagen</h3>
						<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
					<?php
					foreach($this->Data['Template'] as $templates){
							echo '
							<li><a class="th" href="'.$templates['screenshot'].'" data-lightbox="'.$templates['file'].'" data-title="Screenshot Template '.$templates['name'].'"><img src="'.$templates['screenshot'].'" alt="screenshot" /></a></li>';
					}
					?> 
					
						</ul>
						<a class="close-reveal-modal">&#215;</a>
					</div>
					
					<h3 class="subheader">Screenshot</h3>
					<p>Eine Vorschau deines aktuellen Theme.</p>
					<?php
					foreach($this->Data['Template'] as $templates){
						if($templates['activ']){
							$tpl = $templates;
						}
					}
					?> 
					
					<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
					<?php
						echo '
						<li><a class="th" href="'.$tpl['screenshot'].'" data-lightbox="'.$tpl['file'].'" data-title="Screenshot Template '.$tpl['name'].'"><img src="'.$tpl['screenshot'].'" alt="screenshot" /></a></li>';
					?>
					</ul>
					
					<h4 class="subheader">Authorship + Info</h4>
					<textarea readonly rows="10" cols="50" class="authorship">
						<?php echo $tpl['info']; ?>
						
					</textarea>
					<?php break;?>
					<?php case 'user': ?>
					
					<div data-alert class="alert-box warning">
  						<i class="fi-alert"></i>  Du hast keine Berechtigung für diese Aktion! Willst du das Aussehen der Seite ändern, wende dich an den Administrator.
  						<a href="#" class="close">&times;</a>
					</div>
					<?php break;?>
					<?php endswitch;?>
					
	<?php	
}
?>