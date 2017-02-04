<?php
    
 /**
 * Admin Include Sidebar
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
	
					<h2 class="subheader"><i class="fi-results"></i> Sidebar Management</h2>
					<p>Verwalte den Inhalt deiner Panel für eine Sidebar.</p>
					<div class="alert-box warning">Diese Funktion ist optional und muss vom verwendeten Template unterstützt werden.</div>
					<table> 
						<thead> 
							<tr> 
								<th width="100">NR</th> 
								<th>Name</th> 
								<th width="100">Last Mod.</th>
								<th width="100"></th> 
							</tr> 
						</thead> 
						<tbody> 
							<tr> 
								<td>1</td> 
								<td>Panel 1</td> 
								<td><?php echo $this->Data['Sidebar']['panel1']; ?></td> 
								<td><a href="<?php echo DIR; ?>?load=panel&amp;panel=panel1" title="Panel 1" class="button removemargin small">Edit</a></td> 
							</tr>
							<tr> 
								<td>2</td> 
								<td>Panel 2</td> 
								<td><?php echo $this->Data['Sidebar']['panel3']; ?></td> 
								<td><a href="<?php echo DIR; ?>?load=panel&amp;panel=panel2" title="Panel 2" class="button removemargin small">Edit</a></td> 
							</tr>
							<tr> 
								<td>3</td> 
								<td>Panel 3</td> 
								<td><?php echo $this->Data['Sidebar']['panel3']; ?></td> 
								<td><a href="<?php echo DIR; ?>?load=panel&amp;panel=panel3" title="Panel 3" class="button removemargin small">Edit</a></td> 
							</tr>
						</tbody>
					</table>
					
	<?php
}
?>