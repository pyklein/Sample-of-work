<?php
/**
 * Tests pour le formulaire popup utilisateur
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';


$objTest = new lime_test(3);

//On recupere un civilite
$objCivilite = CiviliteTable::getInstance()->getQueryObject()->fetchOne();

$objUtilisateurForm = new Utilisateur_PopupForm();


$arrFormulaireValide = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Jihad',
                        "prenom" => 'Sahebdin',
                        "email" => 'cestununittest@actimage.com');

$arrFormulaireIncomplet = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Jihad');

$arrFormulaireInvalideMail = array("civilite_id" => $objCivilite->getId(),
                        "nom" => 'Jihad',
                        "prenom" => 'Sahebdin',
                        "email" => 'jihad.sahebdin');

/*##################### TEST 1 ###############################*/
$objUtilisateurForm->bind($arrFormulaireValide,array());
$objTest->ok($objUtilisateurForm->isValid(),"Le formulaire est valide.");

/*##################### TEST 2 ###############################*/
$objUtilisateurForm->bind($arrFormulaireIncomplet,array());
$objTest->ok(!$objUtilisateurForm->isValid(),"Le formulaire est incomplet.");

/*##################### TEST 3 ###############################*/
$objUtilisateurForm->bind($arrFormulaireInvalideMail,array());
$objTest->ok(!$objUtilisateurForm->isValid(),"L'email est invalide.");



?>
