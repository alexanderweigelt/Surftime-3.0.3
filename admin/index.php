<?php
    
 /**
 * Admin Index Main-Page
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 
 ?>

<!doctype html>
<html class="no-js" lang="de">
<head>
<meta charset="UTF-8">
	<title><?php if(defined('DIR_PROTECTION') and DIR_PROTECTION){ print($this->SystemInfo['meta']['title']); } ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="robots" content="noindex, nofollow" />
    <?php if(defined('DIR_PROTECTION') and DIR_PROTECTION){ print($this->Library->Foundation()); } ?>
	<link rel="stylesheet" href="admin/css/main.css" />
	<?php if(defined('DIR_PROTECTION') and DIR_PROTECTION){ print($this->Library->Lightbox()); } ?>
</head>

<body>
	<div class="row" id="wrapper">
      <div class="large-12 columns">
	  	<header class="panel">
			<h1><?php if(defined('DIR_PROTECTION') and DIR_PROTECTION){ print($this->SystemInfo['cms']['name']); } ?> <small>CMS</small></h1>
		</header>
		
<?php

if(defined('DIR_PROTECTION') and DIR_PROTECTION){
	
	//Lade den Inhalt der Seite
	require_once $this->siteContent;
	
}
?>

		</div>
	</div>
	<footer> &copy; 2015 &middot; <?php if(defined('DIR_PROTECTION') and DIR_PROTECTION){ print($this->SystemInfo['cms']['author']); } ?></footer>
</body>
</html>