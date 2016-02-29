<?php

/**
 * Install Page
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

set_include_path(realpath(__DIR__ . '/') . PATH_SEPARATOR . get_include_path());
require('includes/bootstrap.php');

$install = new \Controller\InstallController();
echo $install->run();

?>