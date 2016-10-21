<?php
require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');
    

//PREREQUIS: 14 statuts dans la base correctement enchainés.

$objTest = new lime_test(2);

$objStatutRacine = new Statut_dossier_mip();
$objStatutRacine->setIntitule('Racine');
$objStatutRacine->setPrecedentStatutDossierMipId(null);
$objStatutRacine->save();


$arrStatutsOrdonnes = Statut_dossier_mipTable::getInstance()->retrieveStatutsParOrdre();

$objTest->is($arrStatutsOrdonnes[0]->getIntitule(),'Racine',
        "Un statut insere à la racine est bien le premier de la liste ordonnée");

$objStatutRacine->setPrecedentStatutDossierMipId(14);
$objStatutRacine->save();

$arrStatutsOrdonnes = Statut_dossier_mipTable::getInstance()->retrieveStatutsParOrdre();

$objTest->is($arrStatutsOrdonnes[14]->getIntitule(),'Racine',
        "Un statut déplacé à la fin est bien le dernier de la liste ordonnée");
?>
