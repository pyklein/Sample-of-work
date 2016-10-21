<?php

/**Tests unitaires pour rendez_vous
 * Projet : GRID
 * Module : referentiel
 * Date de création : 22/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(5);

$objRdvAvecDate = creerRdv('2010-10-08', '2010-11-09');
$objRdvSansSate = creerRdv(null, null);

$objTest->ok($objRdvAvecDate->isValid(),'Un Rendez_vous valide est detecte avec les dates');
$objTest->ok($objRdvSansSate->isValid(),'Un Rendez_vous valide est detecte sans les dates');

$arrayRdvValide = array('date_prise_rdv'=> '29/03/2011',
//                      'date_rdv' => array('day'=>'', 'month'=>'', 'year'=>''),
                      'date_rdv_date' => '29/03/2011',
                      'date_rdv_heure' => '14:30',
                        "dossier_mip_id" => '1'

//                      'id' => ''
                      );

$arrayRdvInvalideDate = array('date_prise_rdv'=> '29-03-2011',
                      'date_rdv_date' => '29/03/2011',
                      'date_rdv_heure' => '14:30',
                        "dossier_mip_id" => '1'
                      );

$arrayRdvInvalideHeure = array('date_prise_rdv'=> '29/03/2011',
                      'date_rdv_date' => '29/03/2011',
                      'date_rdv_heure' => '14h30',
                        "dossier_mip_id" => '1'
                      );

$testRendezVousForm =  new Rendez_vousForm();

// formulaire avec des données valides
$testRendezVousForm->bind($arrayRdvValide);
$objTest->is($testRendezVousForm->isValid(), true, 'Le formulaire est valide avec des dates FR');

// formulaire avec des données invalides
$testRendezVousForm->bind($arrayRdvInvalideDate);
$objTest->is($testRendezVousForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees.');

// formulaire avec des données invalides
$testRendezVousForm->bind($arrayRdvInvalideHeure);
$objTest->is($testRendezVousForm->isValid(), false, 'Le formulaire est valide une heure malformee.');


function creerRdv($datePriseRdv, $dateRdv){
  $objRdv = new Rendez_vous();
  $objRdv->setDatePriseRdv($datePriseRdv);
  $objRdv->setDateRdv($dateRdv);
  return $objRdv;
}

?>
