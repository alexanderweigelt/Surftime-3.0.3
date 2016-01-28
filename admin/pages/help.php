<?php
    
 /**
 * Admin Single Page - Help
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 

if(defined('DIR_PROTECTION') and DIR_PROTECTION){
	
	//Lade die Navigation der Seite
	require_once DIR_ADMIN.'inc/navigation.php';
?>

<div class="small-12 large-12 columns">
	<h2 class="subheader"><i class="fi-info"></i> Anleitung und Hilfe</h2>
	<p>Hier bekommst du eine ausführliche Anleitung zum Umgang und allen Funktionen.</p>
	<div class="panel callout">
		<p>Schaue auch in unseren Developer Guide als <a href="<?php echo DIR_ADMIN; ?>img/Anleitung-Hilfe.pdf" target="_blank"><i class="fi-page-pdf"> PDF</i></a></p>
	</div>
	<div class="panel">
		<h3 class="subheader">Erste Schritte </h3>
		<p>Nach deinem ersten Login gehe bitte unter <em>Settings &gt; User</em> und klicke den Button <span class="highlightButton">+ Add a User</span>. Nun kannst du dich als neuen Administrator anlegen. Danach lösche den bei Auslieferung bestehenden User „webmaster“. Unter dem Punkt Settings > Site solltest du anschließend alle Angaben gegen deine persönlichen Daten ersetzen. Eine ausführlichere Anleitung über das Erstellen eines neuen Nutzer findest du auch unter dem Kapitel <span class="highlightChapter">Einen neuen User anlegen</span>.
		</p>
		<p><strong>Wichtig:</strong> Die beim Formularfeld <em>E-Mail</em> eingetragene Adresse wird auch für alle Anfragen über das Kontaktformular verwendet.
	Sollten bei Auslieferung der Software mehrere Layout verfügbar sein, so kannst du unter dem Punkt <em>Settings &gt; Theme</em> deinen eignen Style wählen.<br>
	Die wichtigsten Schritte um deine neue Website zu erstellen sind danach getan. Nun kannst du dich deinen Inhalten widmen.
		</p>
	</div>
	<div class="panel">
		<h3 class="subheader">Eine bestehende Seite bearbeiten</h3>
		<p>Gehe auf <em>Start &gt; Pages</em> und klicke bei der zu bearbeitenden Seite den Button <span class="highlightButton">Edit</span>. Nun öffnet sich eine neue Seite mit dem Titel <span class="highlightChapter">Edit Page</span>, wie in Abbildung 1 zusehen. Fülle auf dieser nachfolgend aufgelistete Pflichtfelder aus:
		</p>
		<ul>
			<li>Page Titel </li>
			<li>Slug/URL </li>
			<li>Headline </li>
			<li>Page Body</li>
		</ul>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 1" href="<?php echo DIR_ADMIN; ?>img/abb-11.png" class="th">
				<img data-title="Abbildung 1: Eine Seite erstellen oder editieren auf Edit Page" alt="Abbildung 1" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-11.png">
			</a>
			<figcaption>Abbildung 1: Eine Seite erstellen oder editieren auf <span class="highlightChapter">Edit Page</span></figcaption>
		</figure>
		<p>Danach musst du deine Angaben nur noch speichern, durch einen Klick auf den Button <span class="highlightButton">Save Updates</span>. Überprüfe alles mit einem Blick auf die geänderte Seite. Löschen kann man die Seite durch Klick auf den Button <span class="highlightButton">Delete</span>. 
		</p>
		<p><strong>Wichtig:</strong> Es gibt fünf Seiten die standardmäßig zum System gehören index, contact, imprint, search und error. Bei diesen kann die Slug/URL nicht geändert oder die Seite gelöscht werden.<br>
	Alle nachfolgenden Angaben zur Navigation oder SEO beziehen sich ebenfalls auf Einstellungen von <span class="highlightChapter">Edit Page</span>.<br>
			Du möchtest die zu bearbeitende Seite auch in der Navigation verfügbar bzw. einen bestehenden Menüeintrag ändern oder löschen? Hierfür klicke auf den Button <span class="highlightButton">+Metadaten/Navigation</span>. Es öffnen sich weitere Formularfelder, wie in Abbildung 2 zu sehen. 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 2" href="<?php echo DIR_ADMIN; ?>img/abb-9.png" class="th">
				<img data-title="Abbildung 2: Formularfelder für Angaben zur Navigation und SEO" alt="Abbildung 2" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-9.png">
			</a>
			<figcaption>Abbildung 2: Formularfelder für Angaben zur Navigation und SEO</figcaption>
		</figure>
		<div class="indent">
			<h4 class="subheader">Eine Seite der Navigation hinzufügen, bearbeiten oder löschen</h4>
			<p>Wenn noch kein Eintrag in der Navigation angelegt ist, so klicke den grau hinterlegten Schalter neben der Überschrift <span class="highlightChapter">Menu</span>, wie in Abbildung 3 zu sehen ist. Im Feld <span class="highlightChapter">Anchor Text</span> ist als Pflichtangabe der sichtbare Text des Link anzugeben. Mache hier eine sehr kurze, aber prägnante Angabe. Wenn diese Seite als Untermenüpunkt erscheinen soll, dann wähle im Feld <span class="highlightChapter">Parent Page</span> zu welcher Übergeordneten Site sie gehört. Um die Reihenfolge in deiner Navigation zu beeinflussen, wählst du im Feld <span class="highlightChapter">Priority</span> eine Ziffer. Hier gilt eine niedrigere Zahl für fordere Plätze und umgekehrt.<br>
				Zum löschen des Menüeintrag musst du nur den blau hinterlegten Schalter neben der Überschrift <span class="highlightChapter">Menu</span> klicken, bis dieser grau hinterlegt ist. Nach getaner Änderung gilt auch hier wieder alles zu speichern.</p>
			<figure class="removemargin">
				<a data-lightbox="roadtrip" title="Abbildung 3" href="<?php echo DIR_ADMIN; ?>img/abb-10.png" class="th">
					<img data-title="Abbildung 3: Angaben zur Erstellung eines Menüpunkt" alt="Abbildung 3" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-10.png">
				</a>
				<figcaption>Abbildung 3: Angaben zur Erstellung eines Menüpunkt</figcaption>
			</figure>
			<h4 class="subheader">Angaben für Suchmaschinen machen</h4>
			<p>Weiterhin ist es möglich Angaben zur Suchmaschinenoptimierung zu machen. Im ersten Feld unter dem Punkt SEO wirst du gefragt ob diese Seite für Suchmaschinen sichtbar sein soll. Wenn im Auswahlfeld „index“ gesetzt ist wäre dies gegeben. Gleichzeitig wird diese Seite auch im XML-Sitemap gelistet. In den beiden nachfolgenden Feldern mache Angaben zum Inhalt deiner Seite. Die Meta-Description wird übrigens in Suchmaschinen als erster Indikator für deine Besucher angezeigt und sollte nicht länger als 165 Zeichen sein. Auch nach Änderung dieser Angaben nicht vergessen alles zu speichern. </p>
		</div>
	</div>
	<div class="panel">
		<h3 class="subheader">Eine neue Seite erstellen</h3>
		<p>Gehe auf <em>Start &gt; Pages</em> und klicke den Button <span class="highlightButton">+Add a Page</span>. Nun öffnet sich eine neue Seite mit dem Titel <span class="highlightChapter">Edit Page</span>. Fülle auf dieser alle folgenden Pflichtfelder aus:</p>
		 <ul>
			<li>Page Titel </li>
			<li>Slug/URL </li>
			<li>Headline </li>
			<li>Page Body</li>
		</ul>
		<p>Ebenso können Angaben zum Erstellen eines Navigationseintrag oder der Suchmaschinenoptimierung gemacht werden. Details erfährst du auch im vorherigen Kapitel <span class="highlightChapter">Eine bestehende Seite bearbeiten.</span>
		</p>
		<p><strong>Wichtig:</strong> Die Zuordnung der neuen Seite im Punkt <span class="highlightChapter">Menu</span>, zu einer Übergeordneten Seite (Parent Page), lässt sich erst nach dem Speichern vornehmen.</p>
	</div>
	<div class="panel">
		<h3 class="subheader">Bilder zu deiner Bibliothek hinzufügen</h3>
		<p>Gehe auf <em>Start &gt; Files</em> und wähle durch Klick auf den Button <span class="highlightButton">Datei suchen</span> ein Bild auf deinem lokalen Rechner aus, wie in Abbildung 4 zu sehen ist. Erlaubt sind die Dateitypen <em>jpg, png und gif</em>. Nun beginne den Upload durch Klicken des Button <span class="highlightButton">hochladen</span>.
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 4" href="<?php echo DIR_ADMIN; ?>img/abb-2.png" class="th">
				<img data-title="Abbildung 4: Bilder zum Hochladen auswählen und Upload starten" alt="Abbildung 4" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-2.png">
			</a>
			<figcaption>Abbildung 4: Bilder zum Hochladen auswählen und Upload starten</figcaption>
		</figure>
		<p>Bei Erfolg bekommst du die hochgeladene Datei angezeigt. Unter dem Vorschaubild befindet sich nun ein Formularfeld zur Angabe des Dateinamen, unter dem diese gespeichert werden soll. Zu sehen ist dies in Abbildung 5. Wähle einen möglichst treffenden, aber auch kurzen Namen. Dieser wird zusätzlich umgewandelt und als ALT-Tag im Quelltext verwendet. 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 5" href="<?php echo DIR_ADMIN; ?>img/abb-3.png" class="th">
				<img data-title="Abbildung 5: Dateinamen für ein hochgeladenes Bild vergeben und speichern" alt="Abbildung 5" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-3.png">
			</a>
			<figcaption>Abbildung 5: Dateinamen für ein hochgeladenes Bild vergeben und speichern </figcaption>
		</figure>
		<p>Du hast dein Bild nach dem erfolgreichen Upload nicht gespeichert? Kein Problem. Es wird in einem temporären Ordner für dich aufbewahrt. Eine Übersicht der Inhalt in diesem Ordner findest du durch Klick auf den Button <span class="highlightButton">+Unsaved Media</span>, wie in Abbildung 6 zu sehen ist.
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 6" href="<?php echo DIR_ADMIN; ?>img/abb-4.png" class="th">
				<img data-title="Abbildung 6: Übersicht der Dateien im temporären Ordner" alt="Abbildung 6" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-4.png">
			</a>
			<figcaption>Abbildung 6: Übersicht der Dateien im temporären Ordner</figcaption>
		</figure>
		<p>Im übrigen wird zu jedem hochgeladenen Bild automatisch ein kleines Vorschaubild (Thumbnail) erstellt und gespeichert.<br> 
		<strong>Wichtig:</strong> Um alle Bilder problemlos im Content deiner Seite verwenden zu können, musst du nur den Button für Fotos im Editor deiner Seite klicken. Diesen siehst du in Abbildung 7 mit einem roten Kreis hervorgehoben. Unter dem Punkt <em>Image List</em> findet sich eine Auflistung aller, in der Mediathek befindlichen Bilder.
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 7" href="<?php echo DIR_ADMIN; ?>img/abb-12.png" class="th">
				<img data-title="Abbildung 7: Auswahl eines Bild zum Einfügen in den Inhalt einer Seite" alt="Abbildung 7" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-12.png">
			</a>
			<figcaption>Abbildung 7: Auswahl eines Bild zum Einfügen in den Inhalt einer Seite</figcaption>
		</figure>
	</div>
	<div class="panel">
		<h3 class="subheader">Arbeiten mit Variablen im Page Body deiner Seite</h3>
		<p>Diese Software ist dafür ausgelegt mit vorab definierten Variablen zu arbeiten. Das hat einen Vorteil wenn sich deine persönlichen Daten ändern. Dies sei kurz am Beispiel der Öffnungszeiten erläutert. Um nicht den gesamten Text absuchen zu müssen, und die Zeiten überall von Hand zu ändern, setzte die Variable {%OPENING%}. Nun übernimmt dieser Platzhalter den jeweiligen Wert. Gleiches gilt natürlich auch für alle anderen Angaben wie z.B. Namen oder E-Mail.<br>
		Eben diese Werte werden gesetzt unter <em>Settings &gt; Site</em>, wie auch in Abbildung 8 zu sehen ist. Eine tolle Möglichkeit diese Variablen zu nutzen ist im Impressum deiner Seite. Ein Beispiel nach aktuellem Stand des §5 Telemediendienstgesetz ist bereits vorinstalliert. <br>
		Das Einfügen des Kontakt- bzw. Suchformular ist ebenfalls über Platzhalter gelöst. In Tabelle 1 siehst du alle möglichen Variablen.
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 8" href="<?php echo DIR_ADMIN; ?>img/abb-5.png" class="th">
				<img data-title="Abbildung 8: Variablen für dein gesamtes Projekt verfügbar machen" alt="Abbildung 8" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-5.png">
			</a>
			<figcaption>Abbildung 8: Variablen für dein gesamtes Projekt verfügbar machen</figcaption>
		</figure>
		<p><strong>Wichtig:</strong> Du brauchst Administratorrechte um Variablen speichern oder editieren zu können.</p>
	</div>
    <table> 
        <thead> 
            <tr> 
                <th width="150">Bezeichnung</th> 
                <th width="150">Platzhalter</th> 
                <th>Beschreibung</th> 
                <th width="100">Editierbar</th> 
            </tr> 
        </thead> 
        <tbody> 
            <tr> 
                <td>Kontaktformular</td> 
                <td>&lcub;%CONTACTFORM%&rcub;</td> 
                <td>Erzeugt einen HTML-Quellcode für dein Kontaktformular</td> 
                <td>nein</td> 
            </tr>
            <tr> 
                <td>Statusmeldung Versenden</td> 
                <td>&lcub;%CONTACTFORM_MESSAGE%&rcub;</td> 
                <td>Gib deinen Usern einen Rückmeldung über Erfolg beim Versenden des Kontaktformular. PLatziere diese möglichst nahe dem Kontaktformular. Ausgabe erfolgt in einem Paragraph. Je nach Status hat dieser eine CSS-Klasse error oder success.</td> 
                <td>nein</td> 
            </tr>
            <tr> 
                <td>Suchformular</td> 
                <td>&lcub;%SEARCHFORM%&rcub;</td> 
                <td>Erzeugt einen HTML-Quellcode für dein Suchformular</td> 
                <td>nein</td> 
            </tr>
            <tr> 
                <td>Vorname</td> 
                <td>&lcub;%FIRSTNAME%&rcub;</td> 
                <td>Ersetzt den Platzhalter durch deinen gespeicherten Vornamen. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Nachname</td> 
                <td>&lcub;%LASTNAME%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deinen gespeicherten Nachnamen. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Straße</td> 
                <td>&lcub;%STREET%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deine gespeicherte Straße. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Postleitzahl</td> 
                <td>&lcub;%POSTALZIP%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deine gespeicherte PLZ. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Ort</td> 
                <td>&lcub;%CITY%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deinen gespeicherten Wohnort. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Telefonnummer</td> 
                <td>&lcub;%PHONE%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deine gespeicherte Telefonnummer. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>E-Mail</td> 
                <td>&lcub;%EMAIL%&rcub;</td>
                <td>Ersetzt den Platzhalter durch deine gespeicherte E-Mail Adresse. An jeder Stelle im <em>Page Body</em> beliebig verwendbar. <strong>Wichtig:</strong> Die hier eingetragene Adresse wird auch für alle Anfragen über das Kontaktformular verwendet.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Firmenname (optional)</td> 
                <td>&lcub;%COMPANY%&rcub;</td> 
                <td>Wenn du diese Seite für einen gewerblichen Internetauftritt nutzt, dann wird der Platzhalter durch deinen Firmennamen erstetzt. An jeder Stelle im <em>Page Body</em> beliebig verwendbar.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Öffnungszeiten (optional)</td> 
                <td>&lcub;%OPENING%&rcub;</td> 
                <td>Du hast Öffnungszeiten? Trage sie in dieses Feld. Dann kannst du den Platzhalter beliebig in deinem Inhalt verwenden.</td> 
                <td>ja</td> 
            </tr>
            <tr> 
                <td>Variable (optional)</td> 
                <td>&lcub;%VARIABLE%&rcub;</td> 
                <td>Diese Variable steht zu deiner freien Verfügung. Belege sie mit einem Inhalt, dann kannst du den Platzhalter beliebig in deinem Projekt verwenden.</td> 
                <td>ja</td> 
            </tr>
        </tbody> 
    </table>
    <div class="panel">
		<h3 class="subheader">Einen neuen User anlegen </h3>
		<p>Navigiere zur Seite <em>Settings &gt; User</em> und klicke den Button <span class="highlightButton">+Add a User</span>. Danach öffnet sich eine neue Seite mit der Überschrift <span class="highlightChapter">Edit User</span>, wie in Abbildung 9 zu sehen ist. Alle Felder ausfüllen ist Pflicht. Beachte bitte die Vergabe von Administratorrechten. Wenn du den neuen Nutzer auf den Status User setzt, so kann dieser keine neuen Nutzer anlegen oder bestehende editieren, bzw. löschen. Nicht vergessen nach der Eingabe alles zu speichern.<br>
		<strong>Wichtig:</strong> Bitte merke dir unbedingt dein Passwort. Derzeit existiert noch keine Funktion um sich ein vergessenes zusenden zu lassen! 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 9" href="<?php echo DIR_ADMIN; ?>img/abb-7.png" class="th">
				<img data-title="Abbildung 9: Einen neuen User anlegen oder bestehenden editieren" alt="Abbildung 9" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-7.png">
			</a>
			<figcaption>Abbildung 9: Einen neuen User anlegen oder bestehenden editieren</figcaption>
		</figure>
	</div>
	<div class="panel">
		<h3 class="subheader">Einen bestehenden User editieren oder das Passwort ändern </h3>
		<p>Du musst als Administrator eingeloggt sein um diese Änderungen durchführen zu können. Navigiere auf <em>Settings &gt; User</em> und wähle in der Übersicht den User aus. Klicke den Button <span class="highlightButton">Edit</span>, wie in Abbildung 10 beispielhaft gezeigt wird. Nun gelangst du zur Eingabemaske. Nimm deine Änderungen vor und speichere alles ab. Das Passwort muss bei Änderung einmal wiederholt werden im Feld <span class="highlightChapter">Confirm Password</span>.<br>
		<strong>Wichtig:</strong> Wenn das Passwort bestehen bleiben soll, lasse dieses Feld einfach leer.<br>
			Einen Benutzer löscht man durch Klick auf den Button <span class="highlightButton">Delete</span>. 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 10" href="<?php echo DIR_ADMIN; ?>img/abb-6.png" class="th">
				<img data-title="Abbildung 10: Übersicht angelegter Benutzer" alt="Abbildung 10" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-6.png">
			</a>
			<figcaption>Abbildung 10: Übersicht angelegter Benutzer</figcaption>
		</figure>
	</div>
	<div class="panel">
		<h3 class="subheader">Das Layout der Seite ändern</h3>
		<p>Die Software wird mit einem Standard-Thema ausgeliefert. Dieses nennt sich in jedem Falle <em>Default</em>. Du kannst jedoch ein eigenes erstellen und dieses als Vorlage nutzen. Ebenso ist es möglich ein neues per FTP-Upload hinzu zu fügen. Hierfür benötigst du ein Programm wie z.B. Filezilla. Lade dein neues Template in den Ordner <em>public &gt; templates</em>. Nach erfolgreichem Upload gehe im Administratorbereich auf <em>Settings &gt; Theme</em>. Im Feld <span class="highlightChapter">Template List</span> sollte nun dein neues Template zur Auswahl stehen, wie in Abbildung 11 zu sehen. Danach klicke den Button <span class="highlightButton">setzen</span> und schon ist es aktiv. 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 11" href="<?php echo DIR_ADMIN; ?>img/abb-8.png" class="th">
				<img data-title="Abbildung 11: Ein neues Template setzen" alt="Abbildung 11" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-8.png">
			</a>
			<figcaption>Abbildung 11: Ein neues Template setzen</figcaption>
		</figure>
	</div>
	<div class="panel">
		<h3 class="subheader">Erweitere Funktionen oder Anwendungen durch Plugin</h3>
		<p>Um auf individuelle Wünsche, nach speziellen Anwendungen eingehen zu können, ist diese Software durch Plugin erweiterbar. Ein neues Plugin kann per FTP in den Ordner <em>public &gt; plugin</em> geladen werden. Hierzu benötigst du wieder ein FTP-Programm wie beispielsweise Filezilla. Wichtig ist das der Name des Ordner, in dem sich das Plugin befindet, auch gleichzeitig der Name der PHP-Funktion ist. Im Content (Page Body) ist diese Funktion nun mit folgendem Platzhalter aufrufbar {%FUNCTION|name_func|arg1|arg2%}. Wenn du diese bearbeiten willst, gehe auf <em>Start &gt; Plugin</em> im Administratorbereich. Das Laden und Aufrufen von Plugin ist nur für fortgeschrittene Benutzer mit entsprechender Fachkenntnis geeignet. 
		</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 13" href="<?php echo DIR_ADMIN; ?>img/abb-15.png" class="th">
				<img data-title="Abbildung 13: Ein installiertes Plugin editieren" alt="Abbildung 13" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-15.png">
			</a>
			<figcaption>Abbildung 13: Ein installiertes Plugin editieren</figcaption>
		</figure>
	</div>
	<div class="panel">
		<h3 class="subheader">Inhalte für eine Sidebar editieren (optional)</h3>
		<p>Mit <?php print($this->SystemInfo['cms']['name']); ?> <?php print($this->SystemInfo['cms']['version']); ?> können ab sofort auch Inhalte einer Sidebar editiert werden. Limitiert ist dies auf drei Stück. Gehe auf Start > Sidebar und wähle durch Klick auf den Button <span class="highlightButton">Edit</span> das zu ändernde Panel.</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 14" href="<?php echo DIR_ADMIN; ?>img/abb-13.png" class="th">
				<img data-title="Abbildung 14: Auswahl des zu ändernden Panel" alt="Abbildung 14" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-13.png">
			</a>
			<figcaption>Abbildung 14: Auswahl des zu ändernden Panel</figcaption>
		</figure>
		<p>Trage deinen Inhalt in das Formularfeld ein und speichere anschließend alles. Du kannst bei deinen Inhalten, ebenso wie im Page-Body Variablen nutzen. Sichtbar wird dein Inhalt im vorbestimmten Bereich des Template (Design deiner Seite).</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 15" href="<?php echo DIR_ADMIN; ?>img/abb-14.png" class="th">
				<img data-title="Abbildung 15: Editor (WYSYWIG) für deine Inhalte" alt="Abbildung 15" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-14.png">
			</a>
			<figcaption>Abbildung 15: Editor (WYSIWYG) für deine Inhalte</figcaption>
		</figure>
		<p><strong>Wichtig:</strong> Dein verwendetes Template muss diese Funktion unterstützen!<br>
			Schaue hierzu in die Hinweise und Informationen zum Template, oder wende dich an dessen Author. 
		</p>
	</div>
	<div class="panel">
		<h3 class="subheader">Systemeinstellungen ändern</h3>
		<p>Hier kannst du Verhalten und Darstellung deines System verändern.</p>
		<ol>
			<li><strong>automatischer Logout</strong> Bestimme ob du nach einer bestimmten Zeit automatisch vom Administratornbereich abgemeldet wirst. Schalte es ab, wenn du zum Beispiel an einem größeren Artikel arbeitest.</li>
			<li><strong>Wartungsmodus aktivieren</strong> Du kannst deine Website in einen Wartungsmodus setzen. Es wird ein 503 HTTP-Header gesendet und im Frontend eine Wartungsseite ausgegeben.</li>
		</ol>
		<p><strong>Wichtig:</strong> speichere seine Einstellung nach einer Änderung ab!</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 16" href="<?php echo DIR_ADMIN; ?>img/abb-16.png" class="th">
				<img data-title="Abbildung 16: Schalter zum setzen der Systemeinstellungen" alt="Abbildung 16" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-16.png">
			</a>
			<figcaption>Abbildung 16: Schalter zum setzen der Systemeinstellungen</figcaption>
		</figure>
		<p>Im Punkt Medien kannst du Angaben zur Bildbreite und Bildhöhe machen. Alle Bilder werden nach einem Upload auf die hier voreingestellte maximale Größe verkleinert. Dateien die unter die eingestellte Größe fallen, werden im Original beibehalten.</p>
		<figure class="removemargin">
			<a data-lightbox="roadtrip" title="Abbildung 17" href="<?php echo DIR_ADMIN; ?>img/abb-17.png" class="th">
				<img data-title="Abbildung 17: maximale Breite und Höhe der hochgeladenen Bilder festlegen" alt="Abbildung 17" src="<?php echo DIR_ADMIN; ?>img/thumb-abb-17.png">
			</a>
			<figcaption>Abbildung 17: maximale Breite und Höhe der hochgeladenen Bilder festlegen</figcaption>
		</figure>
	</div>
</div>

		<!-- Load JS library -->
		<?php print($this->Library->jQuery()); ?>
		<?php print($this->Library->FoundationJS()); ?>
		<script src="admin/js/tinymce/tinymce.min.js"></script>
		<script src="admin/js/settings.js"></script>
<?php
}
?>