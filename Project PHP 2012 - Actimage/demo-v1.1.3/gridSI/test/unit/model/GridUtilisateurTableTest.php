<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(3);


//création 6 utilisateurs
//1 Profils SUP-MIP
$supMip = createUser('SUPMIP',0);
//2 Profils USR-MIP
$usrMip1 = createUser('USRMIP',1);
$usrMip2 = createUser('USRMIP',2);
//3 Profils CLI-MIP
$cliMip1 = createUser('CLIMIP',3);
$cliMip2 = createUser('CLIMIP',4);
$cliMip3 = createUser('CLIMIP',5);



//1 Dossier Mip
$dossierMip = new Dossier_mip();
$dossierMip->setStatutDossierMipId(1);
$dossierMip->setTitre('Test');
$dossierMip->setStatutProjetMipId(3);
$dossierMip->setOrganismeMindefId(1);
$dossierMip->save();


//Associer un client mip par innovateur_dossier_mip
$objLienInnovDossier = new Innovateur_dossier_mip();
$objLienInnovDossier->setInnovateur($cliMip1);
$objLienInnovDossier->setDossierMipId($dossierMip->getId());
$objLienInnovDossier->setTypeInnovateurId(2);
$objLienInnovDossier->save();

//Associer un client mip par session transaction
$objLienSessionTransaction = new Session_innovateur_dossier_mip();
$objLienSessionTransaction->setInnovateur($cliMip2);
$objLienSessionTransaction->setTransactionToken('token');
$objLienSessionTransaction->setNouveauTypeId(2);
$objLienSessionTransaction->save();

//TEST 1: retrievePilotesPotentiels donne 3 résultats
$arrPilotesPotentiels = UtilisateurTable::getInstance()->retrievePilotesPotentiels()->execute();
foreach($arrPilotesPotentiels as $key => $objPilotePotentiel){
  
  if ($objPilotePotentiel->getPreNom() != $objPilotePotentiel->getMotDePasse() && $objPilotePotentiel){
    $arrPilotesPotentiels->Remove($key);
  }
}
$objTest->is($arrPilotesPotentiels->count(),'3',"3 Pilotes potentiels sont trouves");

//TEST 2: retrieveInnovateursMIPDisponibles donne 1 résultat
$arrInnovateurDispo = UtilisateurTable::getInstance()->retrieveInnovateursMIPDisponibles('token',$dossierMip->getId())->execute();
foreach ($arrInnovateurDispo as $key => $objInnovateurDispo){
  if ($objInnovateurDispo->getPreNom() != $objInnovateurDispo->getMotDePasse() && $objInnovateurDispo){
    $arrInnovateurDispo->Remove($key);
  }
}
$objTest->is($arrInnovateurDispo->count(),'1',"1 innovateur disponible trouve");

//TEST 3: retrieveInnovateursMIPConcernes donne 2 résultats
$arrInnovateurConcerne = UtilisateurTable::getInstance()->retrieveInnovateursMIPConcernes('token',$dossierMip->getId())->execute();
foreach ($arrInnovateurConcerne as $key => $objInnovateurConcerne){
  if ($objInnovateurConcerne->getPreNom() != $objInnovateurConcerne->getMotDePasse() && $objInnovateurConcerne){
    $arrInnovateurConcerne->Remove($key);
  }
}
$objTest->is($arrInnovateurConcerne->count(),'2',"2 innovateurs concernes trouves");

//$dossierMip->delete();
//$supMip->delete();
//$usrMip1->delete();
//$usrMip2->delete();
//$cliMip1->delete();
//$cliMip2->delete();
//$cliMip3->delete();



function createUser($profil,$num){
  $user = new Utilisateur();
  $user->setCiviliteId(1);
  $user->setNom($profil);
  $user->setPrenom($num);
  $user->setMotDePasse($num);
  $user->setEmail($profil);

  $user->save();

  $profilUser = new Utilisateur_profil();
  switch($profil){
    case 'SUPMIP':
      $profilUser->setProfilId(6);
      break;
    case 'USRMIP':
      $profilUser->setProfilId(7);
      break;
    case 'CLIMIP':
      $profilUser->setProfilId(9);
      break;
  }
  $profilUser->setUtilisateurId($user->getId());
  $profilUser->save();
  return $user;
}
?>




