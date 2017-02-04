<?php
    
 /**
 * Admin Include Mediathek
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
	if(empty($this->Data['Success']['Upload']))
				{ 
				?>
				
					<h2 class="subheader"><i class="fi-archive"></i> Uploaded Files</h2>
					<p>Hier kannst du deine Bilder und Medien verwalten.</p> 
					<div class="formUpload">
						<form action="<?php echo DIR; ?>?action=upload" method="post" enctype="multipart/form-data">
						<div class="small-10 columns">
							<label for="uploadFile">max Size: <?php echo ini_get('upload_max_filesize'); ?>B</label>
						</div>
						<div class="small-12 large-8 columns">		
							<div class="row collapse">	
								<div class="small-8 columns">
									<input id="uploadFile" type="text" placeholder="Choose File" disabled>
								</div>
								<div class="small-4 columns">
									<div class="fileUpload button removemargin postfix">
										<span>Datei suchen</span>
										<!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
										<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo \Controller\Helpers::maxSize('1'); ?>">
										<input type="file" name="uploadfile" class="upload" id="uploadBtn" accept="image/*">
									</div>
								</div>
							</div>
						</div>
				
						<div class="small-12 large-4 columns">
							<input class="button postfix" type="submit" name="upload" value="hochladen">
						</div>           
					</form>
				</div>
				<a href="#" data-reveal-id="myModal">+ Unsaved Media</a>
				<div id="myModal" class="reveal-modal" data-reveal>
  					<h3>Diese Bilder kannst du noch in deine Mediathek übernehmen</h3>
  					<p class="lead"><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Verwende möglichst aussagekräftige Dateinamen.">Bitte vergebe einen Namen vor dem Speichern, oder verwerfe den Upload!</span></p>
  					<?php 
					$list = '
						<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">'; 
						foreach(glob(DIR_IMAGES_TEMP.'*/*.[jpg][png][gif]') as $file)    
						{   
							$list .= '
							<li>
								<img src="'.$file.'" alt="Bild" class="th">
								<form action="'.DIR.'?action=save" method="post">
									<input type="hidden" name="tempimage" value="'.$file.'">
									<input type="text" name="filename" value="" placeholder="Enter your Filename" required>
									<input type="submit" name="copyImage" value="Save" class="button small">
									<a href="'.DIR.'?action=remove&amp;path='.$file.'" class="button small alert">X</a>
								</form>
							</li>
							'; 
						}
						$list .= '
						</ul>
						';
						echo $list;
						?>
  					<a class="close-reveal-modal">&#215;</a>
				</div>
				<?php 
				}
				else{
					
					//Ausgabe nach Upload erfolgreich
					if(!empty($this->Data['Success']['Upload']['dirname'])){
						$list = '
						<h3>Willst du diese Datei in deine Mediathek übernehmen?</h3>
						<p><span data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="Pflichtfeld! Verwende möglichst aussagekräftige Dateinamen.">Du mußt vor dem Speichern einen <em>Dateiname vergeben</em>!</span></p>
						';
						//Alle Bilder aus Ordner laden 
						$list .= '
						<form action="'.DIR.'?action=save" method="post">
						<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">'; 
						foreach(glob(DIR_IMAGES_TEMP.$this->Data['Success']['Upload']['dirname'].'/*.[jpg][png][gif]') as $file)    
						{   
							$list .= '
							<li>
								<a href="'.$file.'" title="Bild" class="th" target="_blank"><img src="'.$file.'" alt="Bild"></a>
							
								<input type="hidden" name="tempimage" value="'.$file.'">
								<input type="text" name="filename" value="" placeholder="Enter your Filename" required>
								<input type="submit" name="copyImage" value="Save" class="button small" onClick="checkUniqueFilename()">
								<a href="'.DIR.'?action=remove&amp;path='.$file.'" class="button small alert">X</a>
							</li>
							'; 
						}
						$list .= '
						</ul>
						</form>';
					}
					else{
						$list = '
						<h2 class="subheader"><i class="fi-refresh"></i> Bitte starte den Upload neu</h2>
						<p>Folgende Dateitypen sind erlaubt: jpg, gif, png</p>
						<a href="'.DIR.'" class="button">weiter</a>
						';
					}
					$list .=  $this->Data['Success']['Upload']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Upload']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Upload']['message'].'<a href="#" class="close">&times;</a></div>';
					echo $list;
				}			
				?> 
				<h3 class="subheader">Mediathek</h3>
				<p>Deine Bilderbibliothek</p>
				<?php
				if(!empty($this->Data['Success']['Save'])){
					echo $this->Data['Success']['Save']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Save']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['Save']['message'].'<a href="#" class="close">&times;</a></div>';
				}
				$allImages = '<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">'; 
				foreach($this->Data['AllImages'] as $image)    
				{  
					$allImages .= '
					<li>
						<a href="'.$image['large'].'" title="Datei: '.$image['basename'].'" data-lightbox="roadtrip"><img src="'.$image['thumb'].'" alt="Datei: '.$image['basename'].'" data-title="Datei: '.$image['basename'].'"></a>
						<a href="'.DIR.'?action=remove&amp;path='.$image['basename'].'" class="button small alert extramargin expand">löschen</a>
					</li>'; 
				}
				$allImages .= '</ul>';
				//Ausgabe der Bilderliste
				echo $allImages;			
	
}
?>