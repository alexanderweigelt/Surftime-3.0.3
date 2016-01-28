<?php
    
 /**
 * Admin Single Page - Setting
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
	
	//Activ Panel
?>
		<dl class="tabs vertical" data-tab> 
			<dd class="tab-title <?php echo $this->Data['Tab'][1]; ?>"><a href="#panel1">Site</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][2]; ?>"><a href="#panel2">User</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][3]; ?>"><a href="#panel3">Theme</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][4]; ?>"><a href="#panel4">Setup</a></dd> 
		</dl> 
		<div class="tabs-content"> 
			<!-- Panel Settings -->
			<div class="content <?php echo $this->Data['Tab'][1]; ?>" id="panel1"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Settings
				require_once DIR_ADMIN.'inc/settings.php';
				?>
				
				</div> 
			</div> 
			<!-- Panel Users -->
			<div class="content <?php echo $this->Data['Tab'][2]; ?>" id="panel2"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Users
				require_once DIR_ADMIN.'inc/users.php';
				?>

				</div>
			</div> 
			<!-- Panel Theme -->
			<div class="content <?php echo $this->Data['Tab'][3]; ?>" id="panel3">
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Theme
				require_once DIR_ADMIN.'inc/theme.php';
				?>
					
				</div> 
			</div> 
			<!-- Panel Theme -->
			<div class="content <?php echo $this->Data['Tab'][4]; ?>" id="panel4">
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Theme
				require_once DIR_ADMIN.'inc/setup.php';
				?>
					
				</div> 
			</div> 
		</div>

		<!-- Load JS library -->
		<?php print($this->Library->jQuery()); ?>
		<?php print($this->Library->FoundationJS()); ?>
		<script src="admin/js/tinymce/tinymce.min.js"></script>
		<script src="admin/js/settings.js"></script>
<?php
}
?>