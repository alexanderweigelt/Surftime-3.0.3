<!doctype html>
<html lang="de-DE">
<head>
	<meta charset="<?php echo $this->Charset; ?>">
	<title><?php echo $this->Title; ?></title>
	<meta name="description" content="<?php echo $this->Description; ?>" />
	<meta name="keywords" content="<?php echo $this->Keywords; ?>" />
	<meta name="robots" content="<?php echo $this->Indexation; ?>, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href="<?php echo $this->PathTemplate; ?>css/style.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php echo $this->Library('jQueryUI'); ?>
</head>

<body>
	<!-- Navigation -->
	<input id="opener" type="checkbox">
	<label for="opener">☰ Menu</label>
	<nav>
<?php echo $this->Menu('Navigation'); ?>
	</nav>
	
	<!-- Header -->
	<header>
		<div class="container">
			<h1><?php echo $this->Headline; ?></h1>	
			<p><?php echo $this->Slogan; ?></p>
		</div>
	</header>
	
	<!-- Content -->
	<section class="wrapper clearfix">
<?php echo $this->Content; ?> 

	</section>
	<aside>
		<div class="container clearfix">
			<div class="grid-3">
				<h3>Öffnungszeiten</h3>
				<?php echo $this->Opening; ?>
				
			</div>
			<div class="grid-3">
				<h3>Kontakt</h3>
				<ul>
					<li><span>Firma:</span> <?php echo $this->Company; ?></li>
					<li><span>Ansprechpartner:</span> <?php echo $this->Firstname; ?> <?php echo $this->Lastname; ?></li>
					<li><span>E-Mail:</span> <?php echo $this->Email; ?></li>
					<li><span>Telefon:</span> <?php echo $this->Phone; ?></li>
				</ul>
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
		</div>
	</aside>
	<footer>
		<div class="container centered">
			<!-- Diese Angaben müssen nach den Lizenzbedingungen erhalten bleiben -->
			<small>&copy; 2014 <?php echo $this->Company; ?> &bull; Powered by Surftime CMS and <a href="http://alexander-weigelt.de">Alexander Weigelt</a>.</small> 
		</div>
	</footer>
	<script src="<?php echo $this->PathTemplate; ?>js/settings.js"></script>
	<script>
	// JavaScript Document

	$( "#accordion" ).accordion();

	$( "#button" ).button();
	$( "#radioset" ).buttonset();

	$( "#tabs" ).tabs();

	$( "#dialog" ).dialog({
		autoOpen: false,
		width: 400,
		buttons: [
			{
				text: "Ok",
				click: function() {
					$( this ).dialog( "close" );
				}
			},
			{
				text: "Cancel",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});

	// Link to open the dialog
	$( "#dialog-link" ).click(function( event ) {
		$( "#dialog" ).dialog( "open" );
		event.preventDefault();
	});

	$( "#datepicker" ).datepicker({
		inline: true
	});

	$( "#slider" ).slider({
		range: true,
		values: [ 17, 67 ]
	});

	$( "#progressbar" ).progressbar({
		value: 20
	});

	$( "#spinner" ).spinner();

	$( "#menu" ).menu();

	$( "#tooltip" ).tooltip();

	$( "#selectmenu" ).selectmenu();

	// Hover states on the static widgets
	$( "#dialog-link, #icons li" ).hover(
		function() {
			$( this ).addClass( "ui-state-hover" );
		},
		function() {
			$( this ).removeClass( "ui-state-hover" );
		}
	);
	</script>
</body>
</html>
