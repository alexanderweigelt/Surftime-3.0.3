<!doctype html>
<html lang="de-DE">
<head>
	<meta charset="<?php echo $this->Charset; ?>">
	<title><?php echo $this->Title; ?></title>
	<meta name="description" content="<?php echo $this->Description; ?>" />
	<meta name="keywords" content="<?php echo $this->Keywords; ?>" />
	<meta name="robots" content="<?php echo $this->Indexation; ?>, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href="<?php echo $this->PathTemplate; ?>img/favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="<?php echo $this->PathTemplate; ?>css/style.min.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
	<div id="wrapper">
		<header>
		<!-- Kopfzeile -->
			<h1><?php echo $this->Headline; ?></h1>
			<p class="slogan"><?php echo $this->Slogan; ?></p>

			<!-- Navigation -->
			<nav>
<?php echo $this->Menu('Navigation'); ?>
			
			</nav>
			
		</header>
		<section id="container" class="clearfix">
		<!-- Inhalt -->
<?php echo $this->Content; ?> 

		</section>		
		
		<!-- Fusszeile -->
		<aside id="widget">
			<div class="clearfix">
				<div class="grid-1">
					<h3>Öffnungszeiten</h3>
					<?php echo $this->Opening; ?>
					
				</div>
				<div class="grid-1">
					<h3>Kontakt</h3>
					<ul>
						<li><span>Firma:</span> <?php echo $this->Company; ?></li>
						<li><span>Ansprechpartner:</span> <?php echo $this->Firstname; ?> <?php echo $this->Lastname; ?></li>
						<li><span>E-Mail:</span> <?php echo $this->Email; ?></li>
						<li><span>Telefon:</span> <?php echo $this->Phone; ?></li>
					</ul>
				</div>
				<div class="grid-1">
					<h3>Information</h3>
					<?php echo $this->Variable; ?>
				
				</div>
				<div class="grid-1">
					<h3>Links</h3>
					<ul class="subnav">
						<li><?php echo $this->Menu('SingleLink', 'index','Home'); ?></li>
						<li><?php echo $this->Menu('SingleLink', 'contact','Kontakt'); ?></li>
						<li><?php echo $this->Menu('SingleLink', 'imprint','Impressum'); ?></li>
					</ul>
				</div>
			</div>
		</aside>
		<footer>
			<!-- Diese Angaben müssen nach den Lizenzbedingungen erhalten bleiben -->
        	<p class="meta">&copy; 2014 <?php echo $this->Company; ?> &bull; Powered by Surftime CMS and <a href="http://alexander-weigelt.de">Alexander Weigelt</a>.</p> 
		</footer>	
	</div>
</body>
</html>
