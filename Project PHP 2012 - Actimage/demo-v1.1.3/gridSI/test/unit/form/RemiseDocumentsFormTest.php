<?php

/* * Tests unitaires pour echeance
 * Projet : GRID
 * Module : referentiel
 * Date de création : 29/03/2011
 * Auteur: Alexandre WETTA
 */

require_once(dirname(__FILE__) . '/../../bootstrap/doctrine.php');

$objTest = new lime_test(5);

$objRemiseDocsForm = new Remise_documentsForm();

$arrFormulaireValide = array("date_reception_ea" => '29/03/2011',
    "date_envoi_ar_ea" => '29/03/2011',
    "date_reception_cr" => '29/03/2011',
    "date_envoi_ar_cr" => '29/03/2011',
    "date_reception_video" => '29/03/2011',
    "date_envoi_ar_video" => '29/03/2011',
    "dossier_mip_id" => '1'
);

$arrFormulaireInvalideUneDate = array("date_reception_ea" => '29-03-2011',
    "date_envoi_ar_ea" => '29/03/2011',
    "date_reception_cr" => '29/03/2011',
    "date_envoi_ar_cr" => '29/03/2011',
    "date_reception_video" => '29/03/2011',
    "date_envoi_ar_video" => '29/03/2011',
    "dossier_mip_id" => '1'
);

$arrFormulaireInvalideEa = array("date_reception_ea" => '29-03-2011',
    "date_envoi_ar_ea" => '29-03-2011',
    "date_reception_cr" => '29/03/2011',
    "date_envoi_ar_cr" => '29/03/2011',
    "date_reception_video" => '29/03/2011',
    "date_envoi_ar_video" => '29/03/2011',
    "dossier_mip_id" => '1'
);

$arrFormulaireInvalideCr = array("date_reception_ea" => '29/03/2011',
    "date_envoi_ar_ea" => '29/03/2011',
    "date_reception_cr" => '29-03-2011',
    "date_envoi_ar_cr" => '29011',
    "date_reception_video" => '29/03/2011',
    "date_envoi_ar_video" => '29/03/2011',
    "dossier_mip_id" => '1'
);

$arrFormulaireInvalideVideo = array("date_reception_ea" => '29/03/2011',
    "date_envoi_ar_ea" => '29/03/2011',
    "date_reception_cr" => '29-03-2011',
    "date_envoi_ar_cr" => '29011',
    "date_reception_video" => '29/03-2011',
    "date_envoi_ar_video" => '293/2011',
    "dossier_mip_id" => '1'
);

// formulaire avec des données valides
$objRemiseDocsForm->bind($arrFormulaireValide);
$objTest->is($objRemiseDocsForm->isValid(), true, 'Le formulaire est valide avec des dates FR.');

// formulaire avec des données invalides
$objRemiseDocsForm->bind($arrFormulaireInvalideUneDate);
$objTest->is($objRemiseDocsForm->isValid(), false, 'Le formulaire est invalide avec une date malformee.');

// formulaire avec des données invalides
$objRemiseDocsForm->bind($arrFormulaireInvalideEa);
$objTest->is($objRemiseDocsForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees dans etat d avancement.');

// formulaire avec des données invalides
$objRemiseDocsForm->bind($arrFormulaireInvalideCr);
$objTest->is($objRemiseDocsForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees dans compte rendu.');

// formulaire avec des données invalides
$objRemiseDocsForm->bind($arrFormulaireInvalideVideo);
$objTest->is($objRemiseDocsForm->isValid(), false, 'Le formulaire est invalide avec des dates malformees dans video.');

?>
