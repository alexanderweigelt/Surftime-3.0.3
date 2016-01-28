<!doctype html>
<html class="no-js" lang="de-DE">
  	<head>
    <meta charset="<?php echo $this->Charset; ?>" />
	<title><?php echo $this->Title; ?></title>
	<meta name="description" content="<?php echo $this->Description; ?>" />
	<meta name="keywords" content="<?php echo $this->Keywords; ?>" />
	<meta name="robots" content="<?php echo $this->Indexation; ?>, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php echo $this->Library('Foundation'); ?>
	<link href="<?php echo $this->PathTemplate; ?>css/style.css" rel="stylesheet" type="text/css" />
	<?php echo $this->Library('jQuery'); ?>
  	</head>
  	<body>

	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">
			<div class="tab-bar">
				<div class="left-small">
					<a role="button" aria-expanded="false" aria-controls="idOfLeftMenu" class="left-off-canvas-toggle menu-icon" ><span></span></a>
				</div>
				<div class="right tab-bar-section">
				<!-- I stretch all the way to the left -->
					<h4 class="title"><i class="fi-telephone"></i> Call: <?php echo $this->Phone; ?></h4>
				</div>
			</div>
 			
			<!-- Off Canvas Menu -->
			<aside class="left-off-canvas-menu">
				<nav class="top-bar" data-topbar role="navigation"> 
					<?php echo $this->Menu('Navigation', 'off-canvas-list'); ?>
						
				</nav>
			</aside>
			
			<!-- main content goes here -->
			<div class="row">
				<div class="large-12 columns">
					<h1><?php echo $this->Headline; ?></h1>	
					<h3 class="subheader"><i class="fi-paw"></i> <?php echo $this->Slogan; ?></h3>
					<hr />
				</div>
			</div>
			
			<div class="row">
  				<div class="large-9 columns" role="content">
          			<article>
<?php echo $this->Content; ?> 
						
			   		</article>
				</div>
				<aside class="large-3 columns">
     				<nav class="fade-out-small">
						<h5><i class="fi-list"></i> Navigation</h5>
						<?php echo $this->Menu('Navigation', 'side-nav'); ?>
						<h5><i class="fi-magnifying-glass"></i> Suche</h5>
						<!-- Searchform -->
						<?php echo $this->Searchform; ?>
					</nav>
					 
					<div class="panel">
						<h5><i class="fi-info"></i> Information</h5>
						<hr />
						<?php echo $this->Variable; ?>
												
					</div>
					<div class="margin-top-bottom">
						<ul data-orbit data-options="animation:slide;pause_on_hover:true;animation_speed:500;navigation_arrows:true;bullets:false;" class="example-orbit">
							<li>
								<img src="<?php echo $this->PathTemplate; ?>images/Bild1.jpg" alt="Muffin 1" />
							</li>
							<li class="active">
								<img src="<?php echo $this->PathTemplate; ?>images/Bild2.jpg" alt="Muffin 2" />
							</li>
							<li>
								<img src="<?php echo $this->PathTemplate; ?>images/Bild3.jpg" alt="Muffin 3" />
							</li>
							<li>
								<img src="<?php echo $this->PathTemplate; ?>images/Bild4.jpg" alt="Muffin 4" />
							</li>
						</ul>
					</div>
					
					<a href="#" data-reveal-id="myModal" class="button large expand"><i class="fi-megaphone icon-middle"></i> Kontakt</a>
					
					<div id="myModal" class="reveal-modal" style="display: none" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  						<h2 id="modalTitle"><i class="fi-comments"></i> Kontakt</h2>
						<p class="lead">Wir freuen uns auf Ihre Nachricht!</p>
						<!-- vCard -->
						<div class="vcard">
							<div class="org"><?php echo $this->Company; ?></div>
							<span class="fn"><?php echo $this->Firstname; ?> <?php echo $this->Lastname; ?></span>
							<div class="adr">
								<div class="street-address"><?php echo $this->Street; ?></div>
								<span class="locality"><?php echo $this->City; ?></span>
								<span class="postal-code"><?php echo $this->Postalzip; ?></span>
							</div>
							<div>
								<span class="email"><?php echo $this->Email; ?></span>
							</div>
							<div>
								<span class="tel"><?php echo $this->Phone; ?></span>
							</div>
						</div>
						<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<div class="panel callout">
  						<h5><i class="fi-clock"></i> Öffnungszeiten</h5>
						<hr />
  						<p><small><?php echo $this->Opening; ?></small></p>
					</div>	
					
        		</aside>
			</div>
			
			<!-- close the off-canvas menu -->
			<a class="exit-off-canvas"></a>

  		</div>
		<footer class="row">
			<div class="large-12 columns">
				<hr/>
				<div class="row">
					<div class="large-8 columns">
						<p>&copy; 2014 <?php echo $this->Company; ?> &bull; Powered by Surftime CMS and <a href="http://alexander-weigelt.de">Alexander Weigelt</a>.</p>
					</div>
					<div class="large-4 columns">
						<ul class="inline-list right">
							<li><?php echo $this->Menu('SingleLink', 'index','Home'); ?></li>
							<li><?php echo $this->Menu('SingleLink', 'contact','Kontakt'); ?></li>
							<li><?php echo $this->Menu('SingleLink', 'imprint','Impressum'); ?></li>
						</ul>
					</div>
				</div>
			</div>
      	</footer>
    
	</div>
	<?php echo $this->Library('FoundationJS'); ?>

  	</body>
</html>