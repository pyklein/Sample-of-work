<?php

/**Tests unitaires pour organisme_mindef
 * Projet : GRID
 * Module : referentiel
 * Date de création : 24/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');
require_once(dirname(__FILE__).'/../../../lib/helper/FormatHelper.php');

$objTest = new lime_test(5);

$objTest->comment('Test de formatDate()');

$strDate = '10/11/2010';
$objTest->is('10/11/2010', formatDate($strDate),"Avec une date au format jj/mm/aaaa formatDate renvoie jj/mm/aaaa");

$strDate = '2010-11-10 12:00:00';
$objTest->is('10/11/2010', formatDate($strDate),"Avec une date au format aaaa-mm-jj hh:mm:ss formatDate renvoie jj/mm/aaaa");

$strDate = '2011-02-03';
$objTest->is('03/02/2011', formatDate($strDate),"Avec une date au format aaaa-mm-jj formatDate renvoie jj/mm/aaaa");

$strDate = '2011-02-02';
$objTest->is('02/02/2011', formatDate($strDate),"Avec une date au format aaaa-mm-jj ou le mois est egal au jour formatDate renvoie jj/mm/aaaa");

$strDate = '17-03-2010';
$objTest->is('17-03-2010', formatDate($strDate),"Avec une date au format jj-mm-aaaa formatDate renvoie jj-mm-aaaa");

?>
