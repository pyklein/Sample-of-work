<?php
/**Tests unitaires pour Prix
 * Projet : GRID
 * Module : referentiel
 * Date de création : 16/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(4);

$objPrixValide = creerPrix('Légion d Honneur');


$objTest->comment('Test estActivable()') ;
$objTest->is($objPrixValide->estActivable(), true, '->estActivable() renvoie true');

$objTest->comment('Test estDesactivable()') ;
$objTest->is($objPrixValide->estDesactivable(), true, '->estDesactivable() renvoie true');


$arrayPrixValide = array('intitule'=> 'Legion d Honneur'
                      );

$arrayPrixSansIntitule = array('intitule'=> ''
                      );

$prixFormTest =  new PrixForm();

// on test le formualire avec des données valides
$prixFormTest->bind($arrayPrixValide);
$objTest->is($prixFormTest->isValid(), true, 'Le formulaire est valide avec des donnees valides');

// on test le formualire avec des données invalides
$prixFormTest->bind($arrayPrixSansIntitule);
$objTest->is($prixFormTest->isValid(), false, 'Le formulaire est invalide sans intitule');


function creerPrix($intitule){
  $objPrix = new Prix();
  $objPrix->setIntitule($intitule);
  $objPrix->setEstActif(true);
  return $objPrix;
}

?>
