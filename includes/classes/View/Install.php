<?php


/**
 * View Install Document
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace View;


/**
 * Class Install
 * @package View
 */

class Install {

	/**
	 * @param $message
	 *
	 * @return string
	 */

	public function step1( $message ) {
        $html = '
        <p>Installiere in wenigen Schritten deine neue Website</p>
        <p>'.$message.'</p>
        <p class="hint">Dein Browser muss Cookies akzeptieren!</p>
        <form action="'.DIR.'" method="post">
		    <input type="hidden" value="step2" name="action">
			<input type="submit" value="starten">
		</form>
		';
        return $html;
    }

	/**
	 * @param array $data
	 *
	 * @return string
	 */

	public function step2( $data = [] ) {
        $html = '
        <h2>Lizenz und Nutzungsvereinbarung</h2>
        <p>'.$data['cms']['name'].' fällt unter den Lizenzvertrag
        <a href="'.$data['license']['legalcode'].'" target="_blank">'.$data['license']['agreement'].'</a><br />
        Bitte beachte nachfolgend genannte Einschränkungen:</p>
        <textarea readonly rows="10" cols="50" class="authorship">
			'.$data['license']['terms'].'

		</textarea>
		<script>
		    function validForm(){
		        if (document.getElementById(\'accept\').checked == false) {
		            alert ("You didn\'t agree to the terms");
		            return false;
                }
                else{
                    return true;
                }
		    }
		</script>
		<form action="'.DIR.'" method="post" onsubmit="return validForm()">
		    <input type="hidden" value="step3" name="action">
			<label for="accept">Nutzungsbedingungen bestätigen
			    <input type="checkbox" name="accept" id="accept" autocomplete="off" required>
			</label>
			<input type="submit" value="weiter">
		</form>
        ';
        return $html;
    }

	/**
	 * @return string
	 */

	public function step3() {
        $html = '
        <form action="'.DIR.'" method="post">
            <input type="hidden" value="step4" name="action">
			<label for="password">Passwort zum Starten der Installation eingeben</label>
			<input type="password" name="password" id="password" autocomplete="off">
			<input type="submit" value="installieren">
		</form>
		';
        return $html;
    }

	/**
	 * @param array $data
	 *
	 * @return string
	 */

	public function finalStep( $data = array() ) {
        $html = '
		<p class="hint success">'.$data['message'].'</p>
		<p class="hint">'.$data['firstlogin'].'
		<br><a href="admin.php" class="button">weiter</a>
		</p>';
        return $html;
    }

	/**
	 * @param $data
	 *
	 * @return string
	 */

	public function error( $data ) {
        $html = '
        <p class="hint error">'.$data.'</p>
        ';
        return $html;
    }

	/**
	 * @param $html
	 * @param $content
	 *
	 * @return mixed
	 */

	private function compileContent( $html, $content ) {
        return str_replace('{%CONTENT%}', $content, $html);
    }

	/**
	 * @param $message
	 *
	 * @return mixed|string
	 */

	public function parse( $message ) {
		$file = PATH_PAGES . INSTALLPAGE;
        if (file_exists($file)) {
            $output = $this->compileContent(file_get_contents($file), $message);
        } else {
            $msg = $file.' not found';
            $output = \View\Error::errDocument($msg);
        }
        return $output;
    }
}