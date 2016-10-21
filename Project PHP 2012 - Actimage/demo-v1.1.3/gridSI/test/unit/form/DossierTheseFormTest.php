<?php
/**Tests unitaires pour AvisEtatMajor
 * Projet : GRID
 * Module : referentiel
 * Date de création : 01/04/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(6);

$objDossierForm = new Dossier_theseForm();

$arrFormulaireValide = array("numero" => 'numero dossier',
                        "titre" => 'titre test',
                        "type_convention_organisme_id" => '1',
    );

$arrFormulaireInvalide = array("numero" => '',
                        "titre" => '',
                        "type_convention_organisme_id" => '1',
    );

$arrFormulaireInvalideTitre = array("numero" => 'numero test',
                        "titre" => '',
                        "type_convention_organisme_id" => '1',
    );

$arrFormulaireInvalideNumero= array("numero" => '',
                        "titre" => 'titre test',
                        "type_convention_organisme_id" => '1',
    );

$arrFormulaireSansTypeConvention= array("numero" => 'numero dossier',
                        "titre" => 'titre test',
                        "type_convention_organisme_id" => '',
    );

 $arrFichierValide = array('fichier_pdf' => array('error'=> 0 , 'name'=> 'fichier.pdf' , 'type' => 'application/pdf', 'tmp_name' => 'C:\wamp\tmp\phpE32B.tmp' , 'size' => 411475 )) ;

 $arrFichierInvalidePdf = array('fichier_pdf' => array('error'=> 0 , 'name'=> 'fichier.doc' , 'type' => 'application/msword', 'tmp_name' => 'C:\wamp\tmp\phpE32B.tmp' , 'size' => 411475 )) ;

 
// formulaire avec des données valides
$objDossierForm->bind($arrFormulaireValide, $arrFichierValide);
$objTest->is($objDossierForm->isValid(), true, 'Le formulaire est valide avec des donnees valides');

// formulaire avec des données invalides
$objDossierForm->bind($arrFormulaireInvalide, array());
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide sans donnees');

// formulaire avec des données invalides
$objDossierForm->bind($arrFormulaireInvalideTitre, array());
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide sans titre');

// formulaire avec des données invalides
$objDossierForm->bind($arrFormulaireInvalideNumero, array());
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide sans numero');

$objDossierForm->bind($arrFormulaireValide, $arrFichierInvalidePdf);
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide si le fichier != pdf');

// formulaire avec des données invalides
$objDossierForm->bind($arrFormulaireSansTypeConvention, array());
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide sans type de convention');

?>
