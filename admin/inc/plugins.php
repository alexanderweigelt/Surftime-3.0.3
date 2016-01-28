<?php
    
 /**
 * Admin Include Plugin Management
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
	
					<h2 class="subheader"><i class="fi-folder-add"></i> Plugin Management</h2>
					<p>Bearbeite und verwalte deine Plugin.</p> 
					<table> 
						<thead> 
							<tr> 
								<th>Name</th> 
								<th width="100"></th> 
							</tr> 
						</thead> 
						<tbody> 
				<?php 
					$tbody = '';
                    if(!empty($this->Data['Plugins'])){
						foreach($this->Data['Plugins'] as $plugin => $path)    
						{   
							$tbody .= '
							<tr> 
								<td>'.$plugin.'</td>
								<td><a href="'.$path.'" class="button removemargin small">Edit</a></td>
							</tr> 
							'; 
						}
                    }
                    else{
                            $tbody .= '
							<tr> 
								<td>Kein Plugin vorhanden</td>
								<td><a href="#" onclick="alert(\'Aktion nicht möglich\')" class="button removemargin small">Edit</a></td>
							</tr> 
							'; 
                    }
					echo $tbody;
				?>
						</tbody> 
					</table>
	<?php
}
?>