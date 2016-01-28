<?php
    
 /**
 * Admin Include Dashboard
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
	
					<h2 class="subheader"><i class="fi-clipboard-notes"></i> Dashboard</h2>
					<p>Willkommen! Erstelle, editiere oder lösche super einfach den Inhalt deiner Website.</p>
					
					<div class="row">
						<div class="small-12 columns">
							<ul class="slider-content" data-orbit data-options="animation:slide;
                  pause_on_hover:true;
                  animation_speed:600;
                  navigation_arrows:true;
                  bullets:true;">
				  				<li data-orbit-slide="headline-1">
    								<div>
										<i class="fi-compass larger"></i>
      									<h3>Die richtige Wahl</h3>
										<p>Mit <?php print($this->SystemInfo['cms']['name']); ?> <?php print($this->SystemInfo['cms']['version']); ?> hast du ein innovatives Content-Management-System. Eine stabiles und zukunftssicheres System, durch stetige Weiterentwicklung und Verbesserung.</p>
    								</div>
  								</li>
  								<li data-orbit-slide="headline-2">
    								<div>
										<i class="fi-web larger"></i>
      									<h3>Gemacht für das Internet von heute</h3>
										<p>Interagiere mit deinen Besuchen über das integrierte Kontaktformular. Stelle deinen Besuchern eine komfortable Suche zur Verfügung. Alles standardmäßig an Bord.</p>
    								</div>
  								</li>
  								<li data-orbit-slide="headline-3">
    								<div>
										<i class="fi-puzzle larger"></i>
      									<h3>Einfach &amp; schnell</h3> 
										<p>Mit diesem System bringst du deine Inhalte schnell ins Web. Konzipiert für eine einfache Anwendung, selbst ohne Programmierkenntnisse.</p> 
    								</div>
  								</li>
  								<li data-orbit-slide="headline-4">
    								<div>
										<i class="fi-paperclip larger"></i>
      									<h3>Flexibel erweiterbar</h3>
										<p>Erweitere im Handumdrehen nützliche Funktionen durch Installieren von Plugin. Wir fertigen diese auch maßgeschneidert, und auf deine Bedürfnisse zugeschnitten an.</p> 
    								</div>
  								</li>
								<li data-orbit-slide="headline-5">
    								<div>
										<i class="fi-comments larger"></i>
      									<h3>Multible User</h3>
										<p>Lege mehrere Benutzer an. So kannst du mit Kollegen oder Freunden gemeinsam an deinem Projekt zu arbeiten. Sicherheit durch Vergabe von Nutzerrechten integriert.</p> 
    								</div>
  								</li>
							</ul>
						</div>
					</div> 
					
					<div class="row">
						<div class="small-12 large-2 columns">
							<div class="panel dashbox"> 
								<ul class="side-nav removepadding">
  									<li><a href="<?php echo DIR.'?load=page' ?>" title="Eine neue Seite erstellen"><i class="fi-page-add large"></i></a></li>
  									<li><a href="<?php echo DIR.'?load=setting' ?>" title="Einstellungen bearbeiten"><i class="fi-page-edit large"></i></a></li>
  									<li class="divider"></li>
  									<li><a href="<?php echo DIR.'?load=help' ?>" title="Hilfe und Anleitung anschauen"><i class="fi-first-aid large"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="small-12 large-5 columns">
							<div class="panel dashbox"> 
								<h4>System Informationen</h4>
								<ul class="circle">
									<li>CMS Name: <?php print($this->SystemInfo['cms']['name']); ?></li>
									<li>Version: <?php print($this->SystemInfo['cms']['version']); ?></li>
									<li>Author: <?php print($this->SystemInfo['cms']['author']); ?></li>
									<li>Erstellung: <?php print($this->SystemInfo['cms']['creation_date']); ?></li>
									<li>Lizenz: <?php print($this->SystemInfo['license']['agreement']); ?></li>
								</ul>
							</div>
						</div>
						<div class="small-12 large-5 columns">
							<div class="panel callout dashbox"> 
								<h4>Support</h4> 
								<p>Du brauchst Hilfe, oder hast ein Problem mit dem du nicht weiter kommst? Schaue in die ausführliche Anleitung. Ich bin aber auch gern für dich da:<br />
								<a href="mailto:<?php print($this->SystemInfo['info']['support']); ?>?Subject=Supportanfrage%20<?php print(str_replace(array(" ", "&amp;"), array("%20", "and"), $this->SystemInfo['cms']['name'])); ?>&amp;Body=Hallo%21%0A%0AIch%20habe%20folgendes%20Problem%20mit%20<?php print(str_replace(array(" ", "&amp;"), array("%20", "and"), $this->SystemInfo['cms']['name'])); ?>%3A%0A%0A%0ABitte%20helfen%20Sie%20mir%21" title="E-Mail">@ E-Mail</a></p>
							</div>
						</div>
					
						<div class="small-12 columns">
							<div class="panel"> 
								<h5 class="subheader">Lizenz und Nutzungsvereinbarung</h5>
								<p><?php print($this->SystemInfo['cms']['name']); ?> fällt unter den Lizenzvertrag <a href="<?php print($this->SystemInfo['license']['legalcode']); ?>" target="_blank"><?php print($this->SystemInfo['license']['agreement']); ?></a><br />
						Bitte beachte nachfolgend genannte Einschränkungen:</p>
						<textarea readonly rows="10" cols="50" class="authorship">
							<?php print($this->SystemInfo['license']['terms']); ?>
							
						</textarea>
						<p>Du benötigst eine Erweiterung der Lizenz (z.B. für eine kommerzielle Nutzung), dann kontaktiere mich einfach: <a href="mailto:<?php print($this->SystemInfo['info']['support']); ?>?Subject=Supportanfrage%20<?php print(str_replace(array(" ", "&amp;"), array("%20", "and"), $this->SystemInfo['cms']['name'])); ?>&amp;Body=Hallo%21%0A%0AIch%20benötige%20eine%20Erweiterung%20der%20Lizenz%20für%20<?php print(str_replace(array(" ", "&amp;"), array("%20", "and"), $this->SystemInfo['cms']['name'])); ?>%3A%0A%0A%0ABitte%20helfen%20Sie%20mir%21" title="E-Mail">@ E-Mail</a></p>
					</div></div></div>
	<?php
}
?>