<?php
    
 /**
 * Admin Include Sidebar
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */


if(defined('DIR_PROTECTION') and DIR_PROTECTION){

	// Start Content here
	?>
	
					<h2 class="subheader"><i class="fi-widget"></i> Setup</h2>
					<p>Verwalte die Systemeinstellungen von <?php print($this->SystemInfo['cms']['name']); ?> <?php print($this->SystemInfo['cms']['version']); ?>.</p>
					<?php
					if(!empty($this->Data['Success']['Setup'])){
						echo $this->Data['Success']['Setup']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Setup']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Setup']['message'].'<a href="#" class="close">&times;</a></div>';
					}

					switch($this->Data['userRole']):
					case 'admin':
					?>
					
					<form action="<?php echo DIR; ?>?load=setting&amp;action=setup" method="post">
					<div class="row">
						<div class="small-12 columns">
							<h3 class="subheader">System</h3>
							<p>Mit diesen Einstellungen kannst du Verhalten und Darstellung deines System verändern.</p>
						</div>
					</div>	
					<div class="enableSetup">
						<div class="row">
							<!-- autom. Logout -->
							<div class="small-12 medium-4 columns">
								<div class="switch radius">		
									<input type="checkbox" id="logout-enable" name="setup[logout]" value="1" <?php if(!empty($this->Data['Setup']['logout'])) echo 'checked';?>>
									<label for="logout-enable" >
										Enable autom. Logout?
									</label>	
								</div>
							</div>
							<div class="small-12 medium-8 columns">
								<p><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Bestimme ob du nach einer bestimmten Zeit automatisch vom Administratornbereich abgemeldet wirst. Schalte es ab, wenn du zum Beispiel an einem größeren Artikel arbeitest.">automatischer Logout</span></p>
							</div>
						</div>	
						<div class="row">
							<!-- Wartungsmodus -->
							<div class="small-12 medium-4 columns">
								<div class="switch radius">		
									<input type="checkbox" id="maintenance-enable" name="setup[maintenance]" value="1" <?php if(!empty($this->Data['Setup']['maintenance'])) echo 'checked';?>>
									<label for="maintenance-enable" >
										Enable Maintenance Mode?
									</label>	
								</div>
							</div>
							<div class="small-12 medium-8 columns">
								<p><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Du kannst deine Website in einen Wartungsmodus setzen. Es wird ein 503 HTTP-Header gesendet und im Frontend eine Wartungsseite ausgegeben.">Wartungsmodus aktivieren</span></p>
							</div>
						</div>
						<!-- Komprimierung aktivieren -->
						<div class="row">
							<div class="small-12 medium-4 columns">
								<div class="switch radius">		
									<input type="checkbox" id="compress-enable" name="setup[compress]" value="1" <?php if(!empty($this->Data['Setup']['compress'])) echo 'checked';?>>
									<label for="compress-enable" >
										Enable Compression?
									</label>	
								</div>
							</div>
							<div class="small-12 medium-8 columns">
								<p><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Du kannst deine Seiten in einem Pufferspeicher zwischenspeichern, und Dateien vor Auslieferung komprimieren lassen. Das Laden deiner Website wird hierdurch schneller.">Komprimierung aktivieren</span></p>
							</div>
						</div>
						<small>Achtung: Bitte nach Änderung speichern!</small>
					</div>
					
					<div class="row">
						<div class="small-12 columns">
							<h3 class="subheader">Medien</h3>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 columns">
							<label for="maxWidth">
								<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Bilder die per Upload in deine Mediathek hochgeladen werden, werden auf die eingestellte maximale Breite verkleinert.">maximale Breite in Pixel:</span> 
								Bildbreite
							</label>
							<input type="text" name="setup[maxwidth]" id="maxWidth" value="<?php echo $this->Data['Setup']['maxwidth']; ?>" placeholder="600" required>
						</div>
						<div class="small-12 medium-6 columns">
							<label for="maxHeight">
								<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Bilder die per Upload in deine Mediathek hochgeladen werden, werden auf die eingestellte maximale Höhe verkleinert.">maximale Höhe in Pixel:</span> 
								Bildhöhe
							</label>
							<input type="text" name="setup[maxheight]" id="maxHeight" value="<?php echo $this->Data['Setup']['maxheight']; ?>" placeholder="400" required>
						</div>
					</div>
					
					<input type="submit" name="setup[submit]" class="button extramargin" value="speichern">
					</form>
					<?php break;?>
					<?php case 'user': ?>
					
					<div data-alert class="alert-box warning">
  						<i class="fi-alert"></i>  Du hast keine Berechtigung für diese Aktion! Willst du deine Systemeinstellungen ändern, wende dich an den Administrator der Seite.
  						<a href="#" class="close">&times;</a>
					</div>
					<?php break;?>
					<?php endswitch;?>
					
	<?php
}
?>