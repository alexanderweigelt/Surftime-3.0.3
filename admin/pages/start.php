<?php
    
 /**
 * Admin Single Page - Start
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
			<dd class="tab-title <?php echo $this->Data['Tab'][1]; ?>"><a href="#panel1">Dashboard</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][2]; ?>"><a href="#panel2">Pages</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][3]; ?>"><a href="#panel3">Files</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][4]; ?>"><a href="#panel4">Plugin</a></dd> 
			<dd class="tab-title <?php echo $this->Data['Tab'][5]; ?>"><a href="#panel5">Sidebar</a></dd> 
		</dl> 
		<div class="tabs-content">
			<!-- Panel Dashboard -->
			<div class="content <?php echo $this->Data['Tab'][1]; ?>" id="panel1"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Dashboard
				require_once DIR_ADMIN.'inc/dashboard.php';
				?>
	
				</div> 
			</div>  
			<!-- Panel Content -->
			<div class="content <?php echo $this->Data['Tab'][2]; ?>" id="panel2"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Content
				require_once DIR_ADMIN.'inc/pages.php';
				?>
	
				</div> 
			</div> 
			<!-- Panel Mediathek -->
			<div class="content <?php echo $this->Data['Tab'][3]; ?>" id="panel3"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Panel Mediathek 
				require_once DIR_ADMIN.'inc/mediathek.php';
				?>
				
				</div>
			</div> 
			<!-- Panel Plugin Management -->
			<div class="content <?php echo $this->Data['Tab'][4]; ?>" id="panel4"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Plugin Management
				require_once DIR_ADMIN.'inc/plugins.php';
				?>
	
				</div> 
			</div> 
			<!-- Panel Sidebar -->
			<div class="content <?php echo $this->Data['Tab'][5]; ?>" id="panel5"> 
				<div class="showtabs clearfix">
				<?php
				//Lade Plugin Management
				require_once DIR_ADMIN.'inc/sidebar.php';
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