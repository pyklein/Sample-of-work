<?php

/**Tests unitaires pour Entite
 * Projet : GRID
 * Module : referentiel
 * Date de création : 14/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(6);

$objEntiteValide = creerEntite('Direction technique', 'DT', 'Strasbourg', '1', '1', '1');
$objEntiteInvalide = creerEntite(null, null, null, null, null, null);

$objTest->comment('Test estActivable()') ;
$objTest->is($objEntiteValide->estActivable(), true, '->estActivable() renvoie true');

$objTest->comment('Test estDesactivable()') ;
$objTest->is($objEntiteValide->estDesactivable(), true, '->estDesactivable() renvoie true');

$arrayEntiteValide = array('intitule'=> 'Direction generale',
                      'abreviation' => 'ABR',
                      'lieu' => 'Strasbourg',
                      'ville_id' => '1',
                      'organisme_mindef_id' => '1',
                      'est_executant' => '1',
                      );

$arrayEntiteSansIntitule = array('intitule'=> '',
                      'abreviation' => 'ABR',
                      'lieu' => 'Strasbourg',
                      'ville_id' => '1',
                      'organisme_mindef_id' => '1',
                      'est_executant' => '1',
                      );

$arrayEntiteSansAbreviation = array('intitule'=> 'Direction generale',
                      'abreviation' => '',
                      'lieu' => 'Strasbourg',
                      'ville_id' => '1',
                      'organisme_mindef_id' => '1',
                      'est_executant' => '1',
                      );

$arrayEntiteSansLieu = array('intitule'=> 'Direction generale',
                      'abreviation' => 'DG',
                      'lieu' => '',
                      'ville_id' => '1',
                      'organisme_mindef_id' => '1',
                      'est_executant' => '1',
                      );

$entiteFormTest =  new EntiteForm();

// on test le formualire avec des données valides
$entiteFormTest->bind($arrayEntiteValide);
$objTest->is($entiteFormTest->isValid(), true, 'Le formulaire est valide avec des donnees valides');

// on test le formualire avec des données invalides
$entiteFormTest->bind($arrayEntiteSansIntitule);
$objTest->is($entiteFormTest->isValid(), false, 'Le formulaire est invalide sans intitule');

// on test le formualire avec des données invalides
$entiteFormTest->bind($arrayEntiteSansAbreviation);
$objTest->is($entiteFormTest->isValid(), false, 'Le formulaire est invalide sans abreviation');

// on test le formualire avec des données invalides
$entiteFormTest->bind($arrayEntiteSansLieu);
$objTest->is($entiteFormTest->isValid(), false, 'Le formulaire est invalide sans lieu');


function creerEntite($intitule, $abreviation, $lieu, $villeid, $organismeMindefId, $estExecutant){
  $objEntite = new Entite();
  $objEntite->setIntitule($intitule);
  $objEntite->setAbreviation($abreviation);
  $objEntite->setLieu($lieu);
  $objEntite->setVilleId($villeid);
  $objEntite->setOrganismeMindefId($organismeMindefId);
  $objEntite->setEstExecutant($estExecutant);
  return $objEntite;
}
?>
