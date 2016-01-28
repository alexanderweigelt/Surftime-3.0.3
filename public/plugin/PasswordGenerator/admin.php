<?php

 /**
 * Plugin Password Generator
 *
 * *Description* Erzeugen von sicheren Passwörtern
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version PLugin PasswordGenerator 1.0.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */
 
if(defined('DIR_PROTECTION') and DIR_PROTECTION){

#Includes
 
include_once(dirname(__FILE__).'/classes/PasswordGenerator.php');

#Function

$password = new PasswordGenerator();

?>

<p>Um deine Installation von Surftime CMS so sicher wie möglich gegen Angriffe von außen zu machen, empfiehlt es sich ein sicheres Passwort zu verwenden. Wenn Du spontan keine Ideen hast, kannst du dieses Tool zum Erzeugen eines neuen Passwort nutzen. Nach dem Generieren kopiere es einfach, und nutze es z.B. zum Anlegen eines neuen Benutzer.</p>
<?php	echo $password->viewHTML(); ?>
<p><strong>Hinweis:</strong> Du kannst nur Passwörter generieren die aus mindestens 5 Zeichen bestehen.</p>

<?php	
}
?>