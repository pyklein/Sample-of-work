<?php
/**Tests unitatires pour Statut_dossier_mipForm
 * Projet : GRID
 * Module : referentiel
 * Date de création : 16/03/2011
 * Auteur: Jihad Sahebdin
 */

//include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(2);

$objStatutFormValide = new Statut_dossier_mipForm();
$objStatutFormValide->bind(array(
    'intitule' => 'Statut Valide'
    ));
$objTest->cmp_ok($objStatutFormValide->isValid(),'==',true,'Statut_dossier_mipForm: Statut valide');

$objStatutFormInValide = new Statut_dossier_mipForm();
$objStatutFormInValide->bind(array(
    'intitule' => ''
    ));
$objTest->cmp_ok($objStatutFormInValide->isValid(),'==',false,'Statut_dossier_mipForm: Intitule vide');
