<?php
/**Tests unitaires pour InnovateurForm
 * Projet : GRID
 * Module : utilisateurs
 * Date de création : 29/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(7);

$objInnovateurForm = new InnovateurForm() ;

$arrFormulaireValide = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => 'Alexandre',
                        "email" => 'alexandre.wetta@actimage.com',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '1',
    );

$arrFormulaireSansNom = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => '',
                        "prenom" => 'Alexandre',
                        "email" => 'alexandre.wetta@actimage.com',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '1',
    );

$arrFormulaireSansPrenom = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => '',
                        "email" => 'alexandre.wetta@actimage.com',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '1',
    );

$arrFormulaireSansEmail = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => 'Alexandre',
                        "email" => '',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '1',
    );

$arrFormulaireAvecFauxEmail = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => 'Alexandre',
                        "email" => 'alexandre.wetta@acti',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '1',
    );

$arrFormulaireSansOrgMindef = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => 'Alexandre',
                        "email" => 'alexandre.wetta@actimage.com',
                        "organisme_mindef_id" => '',
                        "entite_id" => '1',
    );

$arrFormulaireSansEntite = array("civilite_id" => '1',
                        "id" => '',
                        "nom" => 'Wetta',
                        "prenom" => 'Alexandre',
                        "email" => 'alexandre.wetta@actimage.com',
                        "organisme_mindef_id" => '1',
                        "entite_id" => '',
    );

/*##################### TEST 1 ###############################*/
$objInnovateurForm->bind($arrFormulaireValide);
$objTest->is($objInnovateurForm->isValid(),true,"Le formulaire est valide avec des donnees valides.");

/*##################### TEST 2 ###############################*/
$objInnovateurForm->bind($arrFormulaireSansNom);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide sans le nom.");

/*##################### TEST 3 ###############################*/
$objInnovateurForm->bind($arrFormulaireSansPrenom);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide sans le prenom.");

/*##################### TEST 4 ###############################*/
$objInnovateurForm->bind($arrFormulaireSansEmail);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide sans l'email.");

/*##################### TEST 5 ###############################*/
$objInnovateurForm->bind($arrFormulaireAvecFauxEmail);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide avec un email invalide.");

/*##################### TEST 6 ###############################*/
$objInnovateurForm->bind($arrFormulaireSansOrgMindef);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide sans org mindef.");

/*##################### TEST 7 ###############################*/
$objInnovateurForm->bind($arrFormulaireSansEntite);
$objTest->is($objInnovateurForm->isValid(),false,"Le formulaire est invalide sans entité.");

?>
