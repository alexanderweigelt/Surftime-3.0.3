<!doctype html>
<html>
<head>
	<meta charset="<?php echo $this->Charset; ?>">
	<title><?php echo $this->Title; ?></title>
	<meta name="description" content="<?php echo $this->Description; ?>">
	<meta name="keywords" content="<?php echo $this->Keywords; ?>">
	<meta name="robots" content="<?php echo $this->Indexation; ?>, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="<?php echo $this->PathTemplate; ?>img/favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="<?php echo $this->PathTemplate; ?>style/main.min.css" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
	<div class="above" id="top">
        <div class="container">
            <!-- Searchform -->
			<?php echo $this->Searchform; ?>
			
        </div>
	</div>
	<div class="container">
		<!-- Start Header -->
		<header id="site-title">
				<h1><?php echo $this->Headline; ?></h1>
				<h2><?php echo $this->Slogan; ?></h2>
		</header>
		<!-- Start Navigation -->
		<div class="ribbon">
            
            <input id="opener" type="checkbox">
		    <label for="opener">☰</label>
            
			<nav class="ribbon-content" role="navigation">
				<?php echo $this->Menu('Navigation'); ?>
					
			</nav>
		</div>
		
		<div id="wrapper">
            <div class="content clearfix">
                <section class="grid-3">	
			    <!-- Start Content -->
			
				    <?php echo $this->Content; ?> 
				
				
			    <!-- End Content -->						
			    </section>
                <aside class="grid-1">
                    <div class="row panel">
                        <h3>Öffnungszeiten</h3>
                        <?php echo $this->Opening; ?>
                    
                    </div>
                    <div class="row panel"> 
                        <h3>Info</h3>
                        <?php echo $this->Variable; ?>
                    
                    </div>
                    <div class="row panel">
                        <h3>Vorteile</h3>
                        <ul class="check">
                            <li>einfach</li>
                            <li>schnell</li>
                            <li>flexibel</li>
                        </ul>
                    </div>
                </aside>   
            </div>
			
		
			<!-- Start Footer -->
			<footer>
				<div class="content clearfix">
					<div class="grid-1">
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
					</div>
					<div class="grid-2">
						<ul class="centered">
							<li><?php echo $this->Menu('SingleLink', 'index','Home'); ?></li>
							<li><?php echo $this->Menu('SingleLink', 'contact','Kontakt'); ?></li>
							<li><?php echo $this->Menu('SingleLink', 'imprint','Impressum'); ?></li>
						</ul>
					</div>
					<div class="grid-1">
						<a href="#top" id="upstairs">Top</a>
					</div>
				</div>
			</footer>
		</div>
	</div>
    <div class="downstairs">
        <!-- Diese Angaben müssen nach den Lizenzbedingungen erhalten bleiben -->
        <p>&copy; 2014 <?php echo $this->Company; ?> &bull; Powered by <span>Surftime CMS</span> and <a href="http://alexander-weigelt.de" target="_blank">Alexander Weigelt</a>.</p> 
    </div>
</body>
</html>