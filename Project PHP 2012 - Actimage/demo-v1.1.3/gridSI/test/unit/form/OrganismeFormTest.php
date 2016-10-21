<?php
/**
 * Tests pour le formulaire Organisme
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(3);

$objOrganismeForm = new OrganismeForm();

//On recupere un type d'organisme
$objOrganisme = Type_organismeTable::getInstance()->getQueryObject()->fetchOne();


$arrFormulaireValide = array("intitule" => 'OrganismeTest',
                        "abreviation" => 'OT',
                        "type_organisme_id" => $objOrganisme->getId(),
                        );

$arrFormulaireIncomplet = array("intitule" => 'OrganismeTest',
                        "abreviation" => 'OT'
                        );

$arrFormulaireInvalideMail = array("intitule" => 'OrganismeTest',
                        "abreviation" => 'OT',
                        "type_organisme_id" => $objOrganisme->getId()+50,
                        );

/*##################### TEST 1 ###############################*/
$objOrganismeForm->bind($arrFormulaireValide,array());
$objTest->ok($objOrganismeForm->isValid(),"Le formulaire est valide.");

/*##################### TEST 2 ###############################*/
$objOrganismeForm->bind($arrFormulaireIncomplet,array());
$objTest->ok(!$objOrganismeForm->isValid(),"Le formulaire est incomplet.");

/*##################### TEST 3 ###############################*/
$objOrganismeForm->bind($arrFormulaireInvalideMail,array());
$objTest->ok(!$objOrganismeForm->isValid(),"Le type d'organisme est invalide");



?>
