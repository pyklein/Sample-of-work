<?php
/**Tests unitaires pour echeance
 * Projet : GRID
 * Module : referentiel
 * Date de création : 29/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(2);

$soutienForm = new SoutienForm();

$arrFormulaireValide = array("date_emission" => '29/03/2011',
                        "reference" => 'RefTest',
                        "dossier_mip_id" => '1'
    );

$arrFormulaireInvalide = array("date_emission" => '29-03-2011',
                        "reference" => 'RefTest',
                        "dossier_mip_id" => '1'
    );

// formulaire avec des données valides
$soutienForm->bind($arrFormulaireValide);
$objTest->is($soutienForm->isValid(), true, 'Le formulaire est valide avec des dates FR');

// formulaire avec des données invalides
$soutienForm->bind($arrFormulaireInvalide);
$objTest->is($soutienForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees.');


?>
