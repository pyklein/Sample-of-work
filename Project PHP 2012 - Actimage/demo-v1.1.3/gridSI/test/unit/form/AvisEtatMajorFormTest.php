<?php
/**Tests unitaires pour AvisEtatMajor
 * Projet : GRID
 * Module : referentiel
 * Date de création : 29/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(2);

$objAvisEtatMajorForm = new Avis_etatmajorForm();

$arrFormulaireValide = array("date_demande" => '29/03/2011',
                        "date_reception" => '29/03/2011',
                        "date_envoi" => '29/03/2011',
                        "dossier_mip_id" => '1'
    );

$arrFormulaireInvalide = array("date_demande" => '29-03-2011',
                        "date_reception" => '29/03/2011',
                        "date_envoi" => '29/03/2011',
                        "dossier_mip_id" => '1'
    );

// formulaire avec des données valides
$objAvisEtatMajorForm->bind($arrFormulaireValide);
$objTest->is($objAvisEtatMajorForm->isValid(), true, 'Le formulaire est valide avec des dates FR');

// formulaire avec des données invalides
$objAvisEtatMajorForm->bind($arrFormulaireInvalide);
$objTest->is($objAvisEtatMajorForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees.');

?>
