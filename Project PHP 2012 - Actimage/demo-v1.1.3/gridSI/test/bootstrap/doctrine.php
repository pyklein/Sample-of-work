<?php
/* 
 * Bootstrap pour les test unitaires basés sur Doctrine
 * Projet: GRID
 * Module: N/A
 * Date de création : 01/03/2011
 * Auteur: William Richards
 */

include(dirname(__FILE__).'/unit.php');

require_once(dirname(__FILE__).'/../../lib/helper/LibelleHelper.php');
require_once(dirname(__FILE__).'/../../lib/helper/FormatHelper.php');

$configuration = ProjectConfiguration::getApplicationConfiguration( 'gridweb', 'test', true);
sfContext::createInstance($configuration);
new sfDatabaseManager($configuration);


?>
