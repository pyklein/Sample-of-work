<?php
/**
 * Tests Unitaires pour MailTable
 * Projet : GRID
 * Module : referentiel
 * Date de création : 04/03/2011
 * Auteur: William Richards
 */
require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test();

$objDepartementEnBase = DepartementTable::getInstance()->findOneById(1);


$arrVilleValide = array('nom' => 'VilleTest1', 'code_postal' => '67000', 'departement_id' => $objDepartementEnBase->getId());
$arrVilleInvalide = array('nom' =>'VilleTest2','code_postal' =>'codeinvalide','departement_id' =>$objDepartementEnBase->getId());

$objVilleForm1 = new VilleForm();
$objVilleForm1->bind($arrVilleValide);
$objVilleForm2 = new VilleForm();
$objVilleForm2->bind($arrVilleInvalide);

$objTest->ok($objVilleForm1->isValid(), 'Une Ville valide est detectee comme tel'); $objTest->info(($objVilleForm1->getErrorSchema()->__toString()));
$objTest->ok(!$objVilleForm2->isValid(),'Une ville invalide est detectee');



function creerVille($nom, $codePostal, $departement){
  $objVille = new Ville();
  $objVille->setNom($nom);
  $objVille->setCodePostal($codePostal);
  $objVille->setDepartement($departement);

  return $objVille;
}