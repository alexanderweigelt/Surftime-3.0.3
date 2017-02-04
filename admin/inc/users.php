<?php
    
 /**
 * Admin Include User Profile
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

					<h2 class="subheader"><i class="fi-torsos-all"></i> User Profile</h2>
					<p>Hier kannst du deine Benutzer verwalten.</p> 
					<?php switch($this->Data['userRole']):
					case 'admin': 
					if(!empty($this->Data['Success']['User'])){
						echo $this->Data['Success']['User']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['User']['message'].'<a href="#" class="close">&times;</a></div>' : '<div data-alert class="alert-box success">'.$this->Data['Success']['User']['message'].'<a href="#" class="close">&times;</a></div>';
					}
	?>
	
					<a href="<?php echo DIR.'?load=user' ?>" title="add a user">+ Add a User</a>
					<table> 
						<thead> 
							<tr> 
								<th width="100">ID</th> 
								<th>Username</th> 
								<th width="100">Status</th>
								<th width="100"></th> 
							</tr> 
						</thead> 
						<tbody> 
						<?php
						foreach($this->Data['Users'] as $users){
							echo '
							<tr> 
								<td>'.$users['id'].'</td> 
								<td>'.$users['username'].'</td> 
								<td>'.$users['status'].'</td> 
								<td><a href="'.DIR.'?load=user&amp;user='.$users['username'].'" title="'.$users['username'].'" class="button removemargin small">Edit</a></td> 
							</tr> 
							';
						}
						?>
						
						</tbody> 
					</table>
					<?php break;?>
					<?php case 'user': ?>
					
					<div data-alert class="alert-box warning">
  						<i class="fi-alert"></i>  Du hast keine Berechtigung für diese Aktion! Willst du Benutzer editieren oder anlegen, wende dich an den Administrator der Seite. Dies gilt auch für deine Nutzerdaten.
  						<a href="#" class="close">&times;</a>
					</div>
					<?php break;?>
					<?php endswitch;?>
						
	<?php	
}
?>