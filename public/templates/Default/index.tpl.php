<!doctype html>
<html class="no-js" lang="de-DE">
<head>
	<meta charset="<?php echo $this->Charset; ?>">
	<title><?php echo $this->Title; ?></title>
	<meta name="description" content="<?php echo $this->Description; ?>" />
	<meta name="keywords" content="<?php echo $this->Keywords; ?>" />
	<meta name="robots" content="<?php echo $this->Indexation; ?>, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="<?php echo $this->PathTemplate; ?>css/style.css" type="text/css" />
	<link rel="apple-touch-icon" href="<?php echo $this->PathTemplate; ?>img/apple-touch-icon.png">
	<link rel="shortcut icon" href="<?php echo $this->PathTemplate; ?>img/favicon.ico">
	<link rel="author" href="<?php echo $this->PathTemplate; ?>humans.txt" />
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php echo $this->Library('jQuery'); ?>
	<?php echo $this->Library('Modernizr'); ?>
</head>

<body>
	<!--[if lt IE 8]>
		<p class="browserinfo">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<noscript>
		<p class="browserinfo">Your browser does not support JavaScript! Enable this for use all functions.</p>
	</noscript>

	<!-- Navigation -->
	<input id="opener" type="checkbox">
	<label for="opener">
		<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="15px" height="15px" version="1.1">
			<polygon fill="#000000" stroke="black" stroke-width="0.566932" points="0,0 50,0 50,10 0,10 " transform="scale(0.3)"/>
			<polygon fill="#000000" stroke="black" stroke-width="0.566932" points="0,40 50,40 50,50 0,50 " transform="scale(0.3)"/>
			<polygon fill="#000000" stroke="black" stroke-width="0.566932" points="0,20 50,20 50,30 0,30 " transform="scale(0.3)"/>
		</svg>
		Menu
	</label>
	<nav>
<?php echo $this->Menu('Navigation'); ?>

	</nav>
	
	<!-- Header -->
	<header class="container">
		<div class="grid-12">
			<h1><?php echo $this->Headline; ?></h1>
			<p><?php echo $this->Slogan; ?></p>
		</div>
	</header>
	
	<!-- Content -->
	<section class="container clearfix">
		<div class="grid-12">
<?php echo $this->Content; ?> 
		</div>
	</section>
	<aside class="container clearfix">
		<div class="grid-3">
			<h3>Öffnungszeiten</h3>
			<p><?php echo $this->Opening; ?></p>
		</div>
		<div itemscope itemtype="http://schema.org/LocalBusiness" class="grid-3">
			<h3>Kontakt</h3>
			<ul>
				<li><strong>Firma:</strong> <span itemprop="name"><?php echo $this->Company; ?></span></li>
				<li><strong>Ansprechpartner:</strong> <?php echo $this->Firstname; ?> <?php echo $this->Lastname; ?></li>
				<li><strong>E-Mail:</strong> <span itemprop="email"><?php echo $this->Email; ?></span></li>
				<li><strong>Telefon:</strong> <span itemprop="telephone"><?php echo $this->Phone; ?></span></li>
			</ul>
			<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
				<ul>
					<li><span itemprop="streetAddress"><?php echo $this->Street; ?></span></li>
					<li><span itemprop="postalCode"><?php echo $this->Postalzip; ?></span> <span itemprop="addressLocality"><?php echo $this->City; ?></span></li>
				</ul>
			</div>
		</div>
		<div class="grid-3">
			<h3>Information</h3>
			<?php echo $this->Variable; ?>
			
		</div>
		<div class="grid-3">
			<h3>Links</h3>
			<ul>
				<li><?php echo $this->Menu('SingleLink', 'index','Home'); ?></li>
				<li><?php echo $this->Menu('SingleLink', 'contact','Kontakt'); ?></li>
				<li><?php echo $this->Menu('SingleLink', 'imprint','Impressum'); ?></li>
			</ul>
		</div>
	</aside>
	<footer class="container centered">
		<a href="#" class="scrollToTop">Top</a>
		<!-- Diese Angaben müssen nach den Lizenzbedingungen erhalten bleiben -->
		<small>&copy; 2014 <?php echo $this->Company; ?> &bull; Powered by Surftime CMS and <a href="http://alexander-weigelt.de">Alexander Weigelt</a>.</small>
	</footer>
	<script src="<?php echo $this->PathTemplate; ?>js/settings.js"></script>
</body>
</html>