<?php

/**
 * Admin Single Page - Form to send mail for reset password
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

if(defined('DIR_PROTECTION') and DIR_PROTECTION){

	print('
				<div class="small-12 large-6 large-centered columns">
					<form action="'.DIR.'" method="post">
						<fieldset>
						<legend>Forget Password</legend>
						<div>
							<label for="user" class="'.$this->Data['class'].'">E-Mail-Adresse</label>
							<input type="text" id="user" name="emailUser" class="'.$this->Data['class'].'" value="" placeholder="your@email-here.com" required>
						</div>
						<div>
							<input type="hidden" name="action" value="forgetpassword">
							<input class="button expand extramargin" type="submit" name="loginSubmit" value="Senden">
						</div>
						</fieldset>
					</form>
					<p>&larr; '.$this->Menu('SingleLink', 'admin','Login').'</p>
				</div>
		');

}