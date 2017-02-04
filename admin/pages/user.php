<?php
    
 /**
 * Admin Single Page - User
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
	
	//Benutzerverwaltung nur Admin
	if($this->Data['userRole'] == 'admin'){
	
?>
	<div class="small-12 large-12 columns">
			<h2 class="subheader"><i class="fi-torso"></i> Edit User</h2>
			<p>Bearbeite deine Benutzerdaten oder erstelle neue Nutzer.</p>
			<?php
			if(!empty($this->Data['Success']['User'])){
				echo $this->Data['Success']['User']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['User']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['User']['message'].'<a href="#" class="close">&times;</a></div>';
			}
			?>
			<form action="<?php echo $this->Data['Action']; ?>" method="post">
				<div class="small-12 large-12 columns">
					<input type="hidden" name="setUser[id]" id="id" value="<?php echo $this->Data['User']['id']; ?>">
					
					<label for="username">
						<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Vergib einen einzigartigen Benutzernamen. Dieser sollte aus mindestens 5 Zahlen oder Buchstaben bestehen.">Username:</span>
					</label>
					<input type="text" name="setUser[username]" id="username" value="<?php echo $this->Data['User']['username']; ?>" placeholder="Username here..." autocomplete="off" required>
					
					<label for="email">
						<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Unter welcher E-Mail ist dieser Nutzer zu erreichen.">User E-Mail:</span>
					</label>
					<input type="email" name="setUser[email]" id="email" value="<?php echo $this->Data['User']['email']; ?>" placeholder="email@yourdomain.com" autocomplete="off" required>
					
					<label for="userstatus">
						<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Welchen Status erhält dieser Nutzer. Mit dieser Einstellung werden auch gewisse Rechte gesetzt.">User Status:</span>
					</label>
					<select name="setUser[status]" id="userstatus">
					<?php 
					foreach($this->Data['EnumUserstatus'] as $status){
						if($this->Data['User']['status'] == $status){
							$selected = ' selected';
						}
						else{
							$selected = '';
						}
						echo '
						<option value="'.$status.'"'.$selected.'>'.ucfirst($status).'</option>';
					}
					?>
					
					</select>
				</div>
				<div class="small-12 large-6 columns">
					<label for="password">
						<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Achtung! Dies ist nur beim Anlegen eines neuen User als Pflichtfeld zu belegen. Beim editieren solltest du es jedoch leer lassen, wenn das Passwort nicht geändert werden soll.">Password:</span>
					</label>
					<input type="password" name="setUser[password]" id="password" value="" autocomplete="off">
				</div>
				<div class="small-12 large-6 columns">
					<label for="confirmpassword">
						<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Falls das Passwort im vorherigen Feld gesetzt wurde, mußt du es hier durch wiederholte Eingabe bestätigen.">Confirm Password:</span>
					</label>
					<input type="password" name="setUser[confirmpassword]" id="confirmpassword" value="" autocomplete="off">
				</div>
				<input type="submit" name="setUser[submit]" value="speichern" class="button extramargin">
			</form>
			<p><a href="<?php echo $this->Data['Delete']; ?>" title="Delete Page" class="delete"><em>D</em>elete</a></p>
			<small>Registration: <?php echo $this->Data['User']['registration_date']; ?></small>
		</div>
		<!-- Load JS library -->
		<?php print($this->Library->jQuery()); ?>
		<?php print($this->Library->FoundationJS()); ?>
		<script src="admin/js/tinymce/tinymce.min.js"></script>
		<script src="admin/js/settings.js"></script>
<?php
	}
	else{
		echo '<p>Du hast keine Berechtigung zur Benutzerverwaltung!</p>';
	}
}
?>