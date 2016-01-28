<?php
    
 /**
 * Admin Include Page Management
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
	
					<h2 class="subheader"><i class="fi-page-edit"></i> Page Management</h2>
					<p>Hier kannst du deine Seiten verwalten.</p>
					<?php
					if(!empty($this->Data['Success']['Entry'])){
						echo $this->Data['Success']['Entry']['error'] ? '<div data-alert class="alert-box alert">'.$this->Data['Success']['Entry']['message'].'<a href="#" class="close">&times;</a></div>' :'<div data-alert class="alert-box success">'.$this->Data['Success']['Entry']['message'].'<a href="#" class="close">&times;</a></div>';
					}
					?>
					<a href="<?php echo DIR.'?load=page' ?>" title="add a page">+ Add a Page</a>
					<table> 
						<thead> 
							<tr> 
								<th width="100">ID</th> 
								<th>Name</th> 
								<th width="100">Last Mod.</th>
								<th width="100"></th> 
							</tr> 
						</thead> 
						<tbody> 
						<?php
						foreach($this->Data['Entries'] as $entries){
							echo '
							<tr> 
								<td>'.$entries['id'].'</td> 
								<td>'.$entries['page'].'</td> 
								<td>'.$entries['created'].'</td> 
								<td><a href="'.DIR.'?load=page&amp;page='.$entries['page'].'" title="'.$entries['page'].'" class="button removemargin small">Edit</a></td> 
							</tr> 
							';
						}
						?>
						
						</tbody> 
					</table>
					<ul class="pagination">
					<?php
					
				//Pagination
				$n_seiten = $this->Data['Pager']['countEntries'] / $this->Data['Pager']['limitEntries'] ;
				$page = $this->Data['Pager']['pageNumber'];	
                if($page > 0){
                    $i = $page - 1;
                    $url = ($i > 0) ? DIR.'?num='.$i : DIR ;
                    echo "\n\t\t".'<li class="arrow unavailable"><a href="'.DIR.'">&lsaquo;</a></li>';
                }
                for($sn = 0; $sn <= $n_seiten; $sn++) {
                    $xn = $sn + 1;
					$current = ''; 
                    if ($page == $sn){
                        $current = ' class="current"';
                    } 
                    $url = ($sn > 0) ? DIR.'?num='.$sn : DIR ;
                    echo '<li'.$current.'><a href="'.$url.'">'.$xn.'</a></li>'; 
                }
                if($page < ($n_seiten - 1)){
                    $i = $page + 1;
                    $url = DIR.'?num='.$i ;
                    echo "\n\t\t".'<li class="arrow"><a href="'.$url.'">&rsaquo;</a></li>';
                }				
					
					?>	
					</ul>			
	
	<?php	
}
?>