<?php
    
 /**
 * Admin Single Page - Pages
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
	<h2 class="subheader"><i class="fi-page"></i> Edit Page</h2>
	<p>Bearbeite den Inhalt einer Seite oder erstelle eine Neue.</p>
	<?php
	if(!empty($this->Data['Success']['Entry'])){
		echo $this->Data['Success']['Entry']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Entry']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Entry']['message'].'<a href="#" class="close">&times;</a></div>';
	}
	?>
	<form id="editform" action="<?php echo $this->Data['Action']; ?>" method="post">
		<input id="id" name="setEntry[id]" type="hidden" value="<?php echo $this->Data['Entry']['id']; ?>" />			

		<!-- page title toggle screen -->
		<label for="title">
		 	<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Jede HTML-Datei muss einen Titel erhalten. Dieser wird z.B bei der Anzeige im Web-Browser in der Titelzeile des Anzeigefensters angezeigt.">Page Title: </span>
		</label>
		<input id="title" name="setEntry[title]" type="text" value="<?php echo $this->Data['Entry']['title']; ?>" placeholder="Page Title" required>
			
		<label for="page">
			<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Hier kannst du angeben unter welchem Name die Datei gespeichert werden soll. Verwende möglichst aussagekräftige Begriffe. Achtung: Einige Dateien sind Voraussetzung für das System. Diese kannst du werder löschen, noch den Dateiname ändern! Erfahre mehr in der Hilfe.">Slug/URL:</span>	
		</label>
		<input type="text" id="page" name="setEntry[page]" value="<?php echo $this->Data['Entry']['page']; ?>" required>
		
		<!-- metadata toggle screen -->
		<dl class="accordion" data-accordion>
			<dd class="accordion-navigation">
				<a href="#panel1">+ Metadaten/Navigation</a>
				<div id="panel1" class="content">	
					<div class="small-12 large-6 columns">
						<div class="clearfix">	
							<div class="left">
								<h3><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Diese Seite soll in das Hauptmenü übernommen werden? Dann setze den Schalter rechts und mache alle erforderlichen Angaben in den Feldern darunter.">Menu</span></h3>
							</div>
							<div class="right switch radius">		
								<input type="checkbox" id="menu-enable" name="setEntry[menu-enable]" <?php if(!empty($this->Data['Entry']['site_id'])) echo 'checked';?>>
								<label for="menu-enable" >
									Add to Menu?
								</label>	
							</div>
						</div>
						
						<label for="button">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Der englische Ausdruck Anchor-Text wird synonym zum deutschen Ausdruck Link-Text verwendet. Damit wird derjenige Text bezeichnet, der innerhalb eines Link-Tags angeklickt werden kann.">Anchor Text:</span>
						</label>
						<input id="button" name="setEntry[anchor]" type="text" value="<?php echo $this->Data['Entry']['anchor']; ?>" />
								
						<label for="parent">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Diese Seite soll in der Hirarchie unter einem anderen Menüpunkt liegen? Dann gib an welche Seite darüber stehen soll.">Parent Page:</span>	
						</label>
						<select id="parent" name="setEntry[parent]">
						<?php 
							//Alle vorkommenden Kinderelemente suchen und in Array schreiben
							foreach ($this->Data['Navigation'] as $key)
							{
								$child[] = $key['parent'];
							}
							$selectParent = '	<option  value="0" >-</option>';
							foreach($this->Data['Navigation'] as $nav) {
								if($nav['parent'] != $this->Data['Entry']['id']){
									if(!empty($nav['site_id']) and $nav['site_id'] != $this->Data['Entry']['id'] and !($nav['parent'] > 0)){
										$selected = ($this->Data['Entry']['parent'] == $nav['site_id']) ? ' selected' : '';
									$selectParent .= '
							<option  value="'.$nav['site_id'].'"'.$selected.'>'.$nav['page'].'</option>';
									}
								}
								else{
									$selectParent = '<option  value="0" >-</option>';
									break;
								}
							}
							echo $selectParent;
						?>
						
						</select>
								 
						<label for="order">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Zum beeinflussen der Reihenfolge in der Navigation, gib eine Nummer an.">Priority:</span>
						</label>		
						<select id="order" name="setEntry[sorting]" >
						<?php 
						foreach($this->Data['Navigation'] as $sort) {
							if(!empty($sort['sorting']) and $sort['site_id'] == $this->Data['Entry']['id']){
								$sort_nr = $sort['sorting'];
							}
						}
						for ($i = 1; $i <= count($this->Data['Navigation']); $i++) {
							$selected = ($i == $sort_nr) ? ' selected' : '';
							echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
						}
						?>
						
						</select>
						
					</div>
					<div class="small-12 large-6 columns">
						<h3><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="SEO (Search Engine Optimization), aus dem englischen übersetzt für Suchmaschinenoptimierung, steht für die Optimierung von Websites zur besseren Verarbeitung durch Suchmaschinen. Willst du also mit dieser Seite gufunden werden, fülle alle Felder aus.">SEO</span></h3>
						<label for="indexation">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Mit der Angabe 'index' kann Crawlern mitgeteilt werden das ein Durchsuchen ausdrücklich gewünscht wird. Ebenso könnte man hier natürlich mit 'noindex' ein Indexieren verhindern. Die meisten Suchmaschinen halten sich auch an diese Angaben.">Visibility for search engines?</span>	
						</label>
						<select  id="indexation" name="setEntry[indexation]">
						<?php
						foreach($this->Data['EnumIndex'] as $enum){
							$selected = ($enum == $this->Data['Entry']['indexation']) ? ' selected' : '';
							echo '<option value="'.$enum.'"'.$selected.'>'.$enum.'</option>';
						}
						?>
						
						</select>
						
						<label for="keywords">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Schlüsselwörter englisch Keywords bein- halten eine Auflistung der wichtigsten Stichworte des Inhalt. Trage diese durch Komma getrennt ein.">Tags &amp; Keywords:</span>
						</label>
						<input id="keywords" name="setEntry[keywords]" type="text" value="<?php echo $this->Data['Entry']['keywords']; ?>">
							
						<label for="description">
							<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Die Meta-Description beinhalten eine zusätzliche kurze Beschreibung des Inhalt einer Seite. Überdies werden diese Informa- tionen zum Teil in den Suchergebnissen unter dem Link zur jeweiligen Website ausgegeben.">Meta Description:</span>
						</label>
						<input id="description" name="setEntry[description]" type="text" value="<?php echo $this->Data['Entry']['description']; ?>">
						
					</div>
				</div>
			</dd>
		</dl>
		<!-- / metadata toggle screen -->
			
	
		<!-- page body -->
		<label for="headline">
			<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Über einem guten Inhalt steht auch eine gute Überschrift! Diese stellt den ersten Blickfang unserer Besucher dar und bietet bereits eine Einleitung auf das was Ihn erwartet.">Headline &lt;h1&gt;:</span>	
		</label>
		<input id="headline" name="setEntry[headline]" type="text" value="<?php echo $this->Data['Entry']['headline']; ?>" required>
		
		<label for="content">
			<span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Content is King! Besucher und auch Suchmaschinen lieben hochwertige und einzigartige Inhalte. Denn eben wegen dieser Inhalte wird ein User auch diese Website besuchen. Daher ist Kreativität gefragt, denn langweilig verursacht eher eine kurze Besuchsdauer und eine hohe Absprungra te.">Page Body:</span>
		</label>
		<textarea id="content" name="setEntry[content]" rows="10" cols="">
<?php echo $this->Data['Entry']['content']; ?>
		</textarea>
		
		<input class="button extramargin" type="submit" name="setEntry[submitted]" value="Save Updates" onclick="">
		<?php if($this->Data['View']): ?>
		<a href="<?php echo $this->Data['View']; ?>" title="View Page" target="_blank" class="button secondary">View Page</a>
		<?php endif; ?>
		
		<p><a href="<?php echo $this->Data['Delete']; ?>" title="Delete Page" class="delete"><i class="fi-trash"></i>  <em>D</em>elete</a></p>
		<small>Last Saved: <?php echo $this->Data['Entry']['created']; ?></small>
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