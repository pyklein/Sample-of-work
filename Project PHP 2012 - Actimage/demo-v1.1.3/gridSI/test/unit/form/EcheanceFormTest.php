<?php
/**Tests unitaires pour echeance
 * Projet : GRID
 * Module : referentiel
 * Date de création : 28/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(5);

$objEcheanceAvecDate = creerEcheance('2010-10-08', '2010-11-09');
$objEcheanceSansSate = creerEcheance(null, null);

$objTest->ok($objEcheanceAvecDate->isValid(),'Une Echeance valide est detecte avec les dates');
$objTest->ok($objEcheanceSansSate->isValid(),'Une Echeance valide est detecte sans les dates');



$testEcheanceForm =  new EcheanceForm();

$arrayEcheanceValide = array('date_echeance_ea'=> '16/03/2011',
                      'date_echeance_cr' => '16/03/2011',
                      'dossier_mip_id' =>'1'
                      );

$arrayEcheanceInvalideEa = array('date_echeance_ea'=> '16-03-2011',
                      'date_echeance_cr' => '16/032011',
                      'dossier_mip_id' =>'1'
                      );

$arrayEcheanceInvalideCr = array('date_echeance_ea'=> '16/03/2011',
                      'date_echeance_cr' => '16/0311',
                      'dossier_mip_id' =>'1'
                      );

// formulaire avec des données valides
$testEcheanceForm->bind($arrayEcheanceValide);
$objTest->is($testEcheanceForm->isValid(), true, 'Le formulaire est valide avec des dates FR');

// formulaire avec des données invalides
$testEcheanceForm->bind($arrayEcheanceInvalideEa);
$objTest->is($testEcheanceForm->isValid(), false, 'Le formulaire est invalide avec une fausse date echeanceEa.');


// formulaire avec des données invalides
$testEcheanceForm->bind($arrayEcheanceInvalideCr);
$objTest->is($testEcheanceForm->isValid(), false, 'Le formulaire est invalide avec une fausse date echeanceCr.');



function creerEcheance($dateEcheanceEa, $dateEcheanceCr){
  $objRdv = new Echeance();
  $objRdv->setDateEcheanceEa($dateEcheanceEa);
  $objRdv->setDateEcheanceCr($dateEcheanceCr);
  return $objRdv;
}
?>
