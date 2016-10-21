<?php

require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');


$objTest = new lime_test(3);
$arrFormulaireValide = array(
                        "organisme_mindef_id" => '1',
                        "titre" => 'Valide',
                        "statut_dossier_mip_id" => '1'
                        );
$arrFormulaireInvalide = array("numero" => '01',
                        "organisme_mindef_id" => 'C',
                        "pilote_id" => '1',
                        "statut_dossier_mip_id" => '1',
                        "titre" => 'Incomplet');
$arrFormulaireIncomplet = array("numero" => '01',
                        "pilote_id" => '2',
                        "titre" => 'InValide');

$objDossier = new Dossier_mip();
$objDossier->setStatutProjetMipId(3);

$objFormValide = new Dossier_mipForm($objDossier);
$objFormInvalide = new Dossier_mipForm($objDossier);
$objFormIncomplet = new Dossier_mipForm($objDossier);

$objFormValide->bind($arrFormulaireValide,array());
$objFormInvalide->bind($arrFormulaireInvalide,array());
$objFormIncomplet->bind($arrFormulaireIncomplet,array());

$objTest->ok($objFormValide->isValid(), "données valides");
$objTest->ok(! $objFormInvalide->isValid(), "données invalides");
$objTest->ok(! $objFormIncomplet->isValid(), "données incomplètes");


?>
