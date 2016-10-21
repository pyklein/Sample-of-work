<?php
/**Tests unitaires pour le formulaire du dossier_ere
 * Projet : GRID
 * Module : dossier_mris
 * Date de création : 05/04/2011
 * Auteur: Jihad Sahebdin
 */

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(3);

$objDossierForm = new Dossier_ereForm();

$arrFormulaireValide = array("numero_definitif" => 'numero test',
                        "titre" => 'titre test',
    );

$arrFormulaireInvalide = array(
                        "titre" => '',
    );

 $arrFichierPDFValide = array('fichier_pdf' => array( 'name'=> 'sample.pdf' , 'type' => 'application/pdf', 'tmp_name' => 'C:\wamp\tmp\9051504ff002de83521dd26e82d4c6227ee53021.pdf' , 'size' => 411475 )) ;

 $arrFichierPDFInvalide = array('fichier_pdf' => array( 'name'=> 'sample.doc' , 'type' => 'application/msword', 'tmp_name' => 'C:\wamp\tmp\9051504ff002de83521dd26e82d4c6227ee53021.doc' , 'size' => 411475 )) ;


 
// formulaire avec des données valides
$objDossierForm->bind($arrFormulaireValide, $arrFichierPDFValide);
$objTest->is($objDossierForm->isValid(), true, 'Le formulaire est valide avec des donnees valides');

// formulaire avec des données invalides
$objDossierForm->bind($arrFormulaireValide, $arrFichierPDFInvalide);
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide avec un faux fichier pdf');

// formulaire vide
$objDossierForm->bind($arrFormulaireInvalide, array());
$objTest->is($objDossierForm->isValid(), false, 'Le formulaire est invalide avec un titre vide');


