<?php
    
 /**
 * Admin Include Settings
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
	
					<h2 class="subheader"><i class="fi-wrench"></i> Website Variables</h2>
					<p>Hier kannst du deine Variablen verwalten. Nutze diese als flexible Bausteine für variable Inhalte.</p>
					<?php
					if(!empty($this->Data['Success']['Settings'])){
						echo $this->Data['Success']['Settings']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Settings']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Settings']['message'].'<a href="#" class="close">&times;</a></div>';
					}
					?>
					<form action="<?php echo DIR; ?>?load=setting&amp;action=settings" method="post">
						<!-- set slogan -->
						<div class="inputSlogan">
							<label for="slogan">
								<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Wenn dein Template die Verarbeitung eines Slogan unterstützt, kannst du deinen Besuchern eine besondere Botschaft mitteilen. Diese bringt deine Seite oder dein Produkt besonders zur Geltung.">Slogan</span>
							</label>
							<input type="text" name="settings[slogan]" id="slogan" value="<?php echo $this->Data['Setting']['slogan']; ?>" placeholder="Your Slogan here">
						</div>
						<?php if($this->Data['userRole'] == 'admin'): ?>
						<!-- set content varaibles -->
						<div class="inputVariables clearfix">
							<p>Die hier gesetzten Variablen kannst Du im Content deines Projekt nutzen.</p>
							<div class="small-12 large-6 columns">
								<label for="firstname">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deinen Vornamen in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Firstname:</span> 
									{%FIRSTNAME%}
								</label>
								<input type="text" name="settings[firstname]" id="firstname" value="<?php echo $this->Data['Setting']['firstname']; ?>" placeholder="visible Firstname">
								
								<label for="lastname">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deinen Nachnamen in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Lastname:</span> 
									{%LASTNAME%}
								</label>
								<input type="text" name="settings[lastname]" id="lastname" value="<?php echo $this->Data['Setting']['lastname']; ?>" placeholder="visible Lastname">
								
								<label for="street">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deine Straße in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Street:</span> 
									{%STREET%}
									</label>
								<input type="text" name="settings[street]" id="street" value="<?php echo $this->Data['Setting']['street']; ?>" placeholder="Your Street here">
								
								<label for="postalzip">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deine Postleitzahl in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Postalzip:</span>
									{%POSTALZIP%}
								</label>
								<input type="text" maxlength="5" name="settings[postalzip]" id="postalzip" value="<?php echo $this->Data['Setting']['postalzip']; ?>" placeholder="01234">
								
								<label for="city">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deine Stadt in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">City:</span> 
									{%CITY%}
								</label>
								<input type="text" name="settings[city]" id="city" value="<?php echo $this->Data['Setting']['city']; ?>" placeholder="Your City here">
							</div>
							
							<div class="small-12 large-6 columns">
								<label for="phone">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deine Telefonnummer in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Phone:</span> 
									{%PHONE%}
								</label>
								<input type="tel" name="settings[phone]" id="phone" value="<?php echo $this->Data['Setting']['phone']; ?>" placeholder="Phonenumber">
								
								<label for="email">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage deine E-Mail in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">E-Mail:</span> 
									{%EMAIL%}
								</label>
								<input type="email" name="settings[email]" id="email" value="<?php echo $this->Data['Setting']['email']; ?>" placeholder="email@yourdomain.com">
								
								<label for="company">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Trage den Namen deiner Firma in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Company:</span> 
									{%COMPANY%}
								</label>
								<input type="text" name="settings[company]" id="company" value="<?php echo $this->Data['Setting']['company']; ?>" placeholder="The Name of your Company">
								
								<label for="opening">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Du hast Öffnungszeiten? Trage sie in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.">Opening:</span> 
									{%OPENING%}
								</label>
								<input type="text" name="settings[opening]" id="opening" value="<?php echo $this->Data['Setting']['opening']; ?>" placeholder="Open from 10:00 to 18:00">
								
								<label for="variable">
									<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Diese Variable steht zu deiner freien Verfügung. Belege sie mit einem Inhalt, dann kannst du den Platzhalter beliebig in deinem Projekt verwenden.">Variable:</span> 
									{%VARIABLE%}
								</label>
								<input type="text" name="settings[variable]" id="variable" value="<?php echo $this->Data['Setting']['variable']; ?>" placeholder="For your Ideas ...">
							</div>
						</div>
						<?php endif; ?>
						
						<input type="submit" name="settings[submit]" class="button extramargin" value="speichern">
					</form>
	<?php	
}
?>