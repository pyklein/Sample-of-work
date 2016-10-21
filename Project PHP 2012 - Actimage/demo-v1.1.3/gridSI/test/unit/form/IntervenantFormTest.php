<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(7);

//Nombre de laboratoire dans la base
$intLaboratoireCount = LaboratoireTable::getInstance()->getQueryObject()->count();

//On recupere un entité aleatoirement
$objLaboratoire = LaboratoireTable::getInstance()->getQueryObject()->offset(rand(0, $intLaboratoireCount-1))->fetchOne();

//On recupere un organisme mindef different de ce de l'entité
if ($objLaboratoire->getOrganismeId() != null)
{
  $objOrganisme = OrganismeTable::getInstance()->getQueryObject()
                                               ->where("id != ?", $objLaboratoire->getOrganismeId())
                                               ->fetchOne();
}
else
{
  $objService = ServiceTable::getInstance()->getQueryObject()
                                           ->where("id != ?", $objLaboratoire->getServiceId())
                                           ->fetchOne();
  $objOrganisme = $objService->getOrganisme();
}


//On recupere un service different de l'organisme  et le laboratoire choisi precedement
$objService = ServiceTable::getInstance()->getQueryObject()
                                        ->where("organisme_id != ?", $objLaboratoire->getOrganismeId())
                                        ->andWhere("organisme_id != ?", $objOrganisme->getId())
                                        ->fetchOne();

//On recupere un civilite
$objCivilite = CiviliteTable::getInstance()->getQueryObject()->fetchOne();

$arrFormulaireValide = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireIncomplet = array("nom" => 'Petev');

$arrFormulaireInvalideMail = array("civilite_id" => $objCivilite->getId(),
                        'email' => 'simeon.petev',
                        "nom" => 'Petev',
                        "prenom" => 'Simeon');

$arrFormulaireInvalideTel = array("civilite_id" => $objCivilite->getId(),
                        'telephone_fixe' => '055464fff',
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideServiceOrg = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "service_id"=>$objService->getId(),
                        "organisme_id"=>$objOrganisme->getId(),
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideServiceLabo = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "service_id"=>$objService->getId(),
                        "laboratoire_id"=>$objLaboratoire->getId(),
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideLaboOrg = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "laboratoire_id"=>$objLaboratoire->getId(),
                        "organisme_id"=>$objOrganisme->getId(),
                        "email" => 'cestununittest@actimage.com');

$objUtiilisateurForm = new IntervenantForm();

/*##################### TEST 1 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireValide,array());
$objTest->ok($objUtiilisateurForm->isValid(),"La forme est valide.");

/*##################### TEST 2 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireIncomplet,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"La forme est incomplet.");

/*##################### TEST 3 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideMail,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'email est invalide.");

/*##################### TEST 4 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideTel,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Le telephone est invalide.");

/*##################### TEST 5 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideServiceLabo,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Le service n'est pas compatible avec le laboratoire.");

/*##################### TEST 6 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideServiceOrg,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Le service n'est pas compatible avec l'organisme.");

/*##################### TEST 7 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideLaboOrg,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Le laboratoire n'est pas compatible avec l'organisme.");


?>
