<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(9);

//Nombre d'entite dans la base
$intEntiteCount = EntiteTable::getInstance()->getQueryObject()->count();

//On recupere un entité aleatoirement
$objEntite = EntiteTable::getInstance()->getQueryObject()->offset(rand(0, $intEntiteCount-1))->fetchOne();

//On recupere un organisme mindef different de ce de l'entité
$objOrganismeMindef = Organisme_mindefTable::getInstance()->getQueryObject()
                                                              ->where("id != ?", $objEntite->getOrganismeMindefId())
                                                              ->fetchOne();

//On recupere un grade different de l'organisme MINDEF et l'entite choisi precedement
$objGrade = GradeTable::getInstance()->getQueryObject()
                                        ->where("organisme_mindef_id != ?", $objEntite->getOrganismeMindefId())
                                        ->andWhere("organisme_mindef_id != ?", $objOrganismeMindef->getId())
                                        ->fetchOne();

//On recupere un civilite
$objCivilite = CiviliteTable::getInstance()->getQueryObject()->fetchOne();

$objUtiilisateurForm = new UtilisateurForm();


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

$arrFormulaireInvalideMailPerso = array("civilite_id" => $objCivilite->getId(),
                        'email_perso' => 'simeon.petev@',
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideDates = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "date_naissance" => "06/05/2004",
                        "date_deces" => "05/05/2003",
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideEntiteOrg = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "entite_id"=>$objEntite->getId(),
                        "organisme_mindef_id"=>$objOrganismeMindef->getId(),
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideEntiteGrade = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "entite_id"=>$objEntite->getId(),
                        "grade_id"=>$objGrade->getId(),
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireInvalideGradeOrg = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Petev',
                        "prenom" => 'Simeon',
                        "grade_id"=>$objGrade->getId(),
                        "organisme_mindef_id"=>$objOrganismeMindef->getId(),
                        "email" => 'cestununittest@actimage.com');

/*##################### TEST 1 ###############################*/
$objUtilisateur = UtilisateurTable::getInstance()->getQueryObject()->fetchOne();

$objUtiilisateurForm = new UtilisateurForm($objUtilisateur);

$objUtiilisateurForm->bind($arrFormulaireValide,array());

$objTest->ok($objUtiilisateurForm->isValid(),"La forme est valide.");

/*##################### TEST 2 ###############################*/
$objUtiilisateurForm = new UtilisateurForm();

$objUtiilisateurForm->bind($arrFormulaireIncomplet,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"La forme est incomplet.");

/*##################### TEST 3 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideMail,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'email est invalide.");

/*##################### TEST 4 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideMailPerso,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'email perso est invalide.");

/*##################### TEST 5 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideTel,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Le telephone est invalide.");

/*##################### TEST 6 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideDates,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"Les dates de naissance et de deces ne forme pas un interval valide.");

/*##################### TEST 7 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideEntiteOrg,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'entite n'est pas compatible avec l'Organisme de MINDEF.");

/*##################### TEST 8 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideEntiteGrade,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'entite n'est pas compatible avec le grade.");

/*##################### TEST 9 ###############################*/
$objUtiilisateurForm->bind($arrFormulaireInvalideGradeOrg,array());
$objTest->ok(!$objUtiilisateurForm->isValid(),"L'organisme MINDEF n'est pas compatible avec le grade.");


?>
