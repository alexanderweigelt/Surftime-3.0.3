<?php
    
 /**
 * Admin Sidebar - Panel
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 

if(defined('DIR_PROTECTION') and DIR_PROTECTION){
	
	//Lade die Navigation der Seite
	require_once DIR_ADMIN.'inc/navigation.php';
	
?>
<div class="small-12 large-12 columns">
	<h2 class="subheader"><i class="fi-clipboard-notes"></i> Edit Panel</h2>
	<p>Bearbeite den Inhalt deiner Panel.</p>
	<?php
	if(!empty($this->Data['Success']['Panel'])){
		echo $this->Data['Success']['Panel']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Panel']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Panel']['message'].'<a href="#" class="close">&times;</a></div>';
	}
	?>
	<form id="editform" action="<?php echo $this->Data['Action']; ?>" method="post">
		<input id="id" name="updatePanel[number]" type="hidden" value="<?php echo $this->Data['Panel']['number']; ?>" />			
	
		<label for="content">
			<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Wenn dein verwendetes Template eine Panel bzw. Sidbar mit editierbarem Inhalt untestützt, so kannst du diese Inhalte hier ändern und speichern.">Panel Content:</span>
		</label>
		<textarea id="content" name="updatePanel[widget]" rows="10" cols="">
<?php echo $this->Data['Panel']['widget']; ?>
		</textarea>
		
		<input class="button extramargin" type="submit" name="updatePanel[submitted]" value="Save Updates" onclick="">
		
		<div>
			<small>Last Saved: <?php echo $this->Data['Panel']['last_modified']; ?></small>
		</div>
	</form>
	
</div>

		<!-- Load JS library -->
		<?php print($this->Library->jQuery()); ?>
		<?php print($this->Library->FoundationJS()); ?>
		<script src="admin/js/tinymce/tinymce.min.js"></script>
		<script src="admin/js/settings.js"></script>
<?php
}
?>