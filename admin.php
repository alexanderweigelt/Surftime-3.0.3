<?php

/**
 * Admin Page
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

set_include_path(realpath(__DIR__ . '/') . PATH_SEPARATOR . get_include_path());
require('includes/bootstrap.php');

$admin = new \Controller\AdminController();
echo $admin->run();

?>