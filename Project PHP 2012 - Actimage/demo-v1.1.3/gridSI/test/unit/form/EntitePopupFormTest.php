<?php
/**Tests unitaires pour la popup Entite
 * Projet : GRID
 * Module : referentiel
 * Date de création : 05/05/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(4);

$arrayEntiteValide = array('intitule'=> 'Direction generale',
                      'abreviation' => 'ABR',
                      'organisme_mindef_id' => '1',
                      );

$arrayEntiteSansAbreviation = array('intitule'=> 'Direction generale',
                      'abreviation' => '',
                      'organisme_mindef_id' => '1',
                      );

$arrayEntiteSansOrgmindef = array('intitule'=> 'Direction generale',
                      'abreviation' => 'Abr',
                      'organisme_mindef_id' => '',
                      );

$arrayEntiteSansIntitule = array('intitule'=> '',
                      'abreviation' => 'Abr',
                      'organisme_mindef_id' => '1',
                      );

$testEntitePopupForm = new EntitePopupForm();

// on test le formualire avec des données valides
$testEntitePopupForm->bind($arrayEntiteValide);
$objTest->is($testEntitePopupForm->isValid(), TRUE, 'Le formulaire est valide avec des donnees valides');

// on test le formualire avec des données valides
$testEntitePopupForm->bind($arrayEntiteSansAbreviation);
$objTest->is($testEntitePopupForm->isValid(), FALSE, 'Le formulaire est invalide sans l abreviation');

// on test le formualire avec des données valides
$testEntitePopupForm->bind($arrayEntiteSansOrgmindef);
$objTest->is($testEntitePopupForm->isValid(), FALSE, 'Le formulaire est invalide sans l organisme Mindef');

// on test le formualire avec des données valides
$testEntitePopupForm->bind($arrayEntiteSansIntitule);
$objTest->is($testEntitePopupForm->isValid(), FALSE, 'Le formulaire est invalide sans l intitule');


?>
