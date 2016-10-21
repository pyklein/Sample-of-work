<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../bootstrap/doctrine.php';

$objTest = new lime_test(5);

//Init le generateur alleatoire
srand(microtime());

//Nombre d'entites dans la base
$intEntiteCount = EntiteTable::getInstance()->getQueryObject()->count();

//On recupere un entité aleatoirement
$objEntite = EntiteTable::getInstance()->getQueryObject()->offset(rand(0, $intEntiteCount-1))->fetchOne();

//On recupere un organisme mindef different de ce de l'entité
$objOrganismeMindef = Organisme_mindefTable::getInstance()->getQueryObject()
                                                              ->where("id != ?", $objEntite->getOrganismeMindefId())
                                                              ->fetchOne();

//On recupere un profil
$objProfil = ProfilTable::getInstance()->getQueryObject()->fetchOne();

$strFieldNom_1 = getChAleat();

$objFiltreValide_1 = new UtilisateurFormFilter();
$objFiltreValide_1->bind(array(
    'nom' => $strFieldNom_1,
    'organisme_mindef_id' => $objEntite->getOrganismeMindefId(),
    'entite_id' => $objEntite->getId(),
    'profil_id' => $objProfil->getId()
));

//Va servir a evaluer le test
$boolResultatVerification = true;

//Resultat du filtre
$arrResultatFiltre = UtilisateurTable::getInstance()->getQueryUtilisateursAvecFiltre($objFiltreValide_1)->execute();

//Recupere les utilisateurs avec le profil precedement choisi
$arrUtilisateursAvecProfil = Utilisateur_profilTable::getInstance()->getQueryObject()
                                                                        ->where("profil_id = ?",$objProfil->getId())
                                                                        ->execute();

$boolResultatVerification = verifierValidite($arrResultatFiltre,
                                             $arrUtilisateursAvecProfil,
                                             $strFieldNom_1,
                                             $objEntite,
                                             $objOrganismeMindef);


/*##################### TEST 1 ###############################*/
$objTest->ok($boolResultatVerification, "Les resultat recupere avec le filtre valide sont valides");



//On recupere un entité aleatoirement
$objEntite = EntiteTable::getInstance()->getQueryObject()->offset(rand(0, $intEntiteCount-1))->fetchOne();

//On recupere un organisme mindef different de ce de l'entité
$objOrganismeMindef = Organisme_mindefTable::getInstance()->getQueryObject()
                                                              ->where("id != ?", $objEntite->getOrganismeMindefId())
                                                              ->fetchOne();
//On recupere un profil
$objProfil = ProfilTable::getInstance()->getQueryObject()->fetchOne();

$strFieldNom_2 = getChAleat();

$objFiltreValide_2 = new UtilisateurFormFilter();
$objFiltreValide_2->bind(array(
    'nom' => $strFieldNom_2,
    'organisme_mindef_id' => $objEntite->getOrganismeMindefId(),
    'entite_id' => $objEntite->getId(),
    'profil_id' => $objProfil->getId()
));

//Va servir a evaluer le test
$boolResultatVerification = true;

//Resultat du filtre
$arrResultatFiltre = UtilisateurTable::getInstance()->getQueryUtilisateursAvecFiltre($objFiltreValide_2)->execute();

//Recupere les utilisateurs avec le profil precedement choisi
$arrUtilisateursAvecProfil = Utilisateur_profilTable::getInstance()->getQueryObject()
                                                                        ->where("profil_id = ?",$objProfil->getId())
                                                                        ->execute();

$boolResultatVerification = verifierValidite($arrResultatFiltre,
                                             $arrUtilisateursAvecProfil,
                                             $strFieldNom_2,
                                             $objEntite,
                                             $objOrganismeMindef);

/*##################### TEST 2 ###############################*/
$objTest->ok($boolResultatVerification, "Les resultat recupere avec le filtre valide sont valides");


//On recupere un entité aleatoirement
$objEntite = EntiteTable::getInstance()->getQueryObject()->offset(rand(0, $intEntiteCount-1))->fetchOne();

//On recupere un organisme mindef different de ce de l'entité
$objOrganismeMindef = Organisme_mindefTable::getInstance()->getQueryObject()
                                                              ->where("id != ?", $objEntite->getOrganismeMindefId())
                                                              ->fetchOne();
$strFieldNom_3 = getChAleat();

$objFiltreInvalide_1 = new UtilisateurFormFilter();
$objFiltreInvalide_1->bind(array(
    'nom' => $strFieldNom_3,
    'organisme_mindef_id' => $objOrganismeMindef->getId(),
    'entite_id' => $objEntite->getId(),
    'profil_id' => ''
));

//Resultat du filtre
$intResultatFiltre = UtilisateurTable::getInstance()->getQueryUtilisateursAvecFiltre($objFiltreInvalide_1)->count();

/*##################### TEST 3 ###############################*/
$objTest->is($intResultatFiltre,0, "Pas de resultat si un filtre incorect");

//Le utilisateur est sensé être dans la base de données de test
$strEmail = "simeon.petev@actimage.com";
$strMotDePasse = "actimage";

$objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMailEtMotDePasse($strEmail,$strMotDePasse);
$intTestResult = strcmp($objUtilisateur->getEmail(), $strEmail) + strcmp($objUtilisateur->getMotDePasse(), sha1($strMotDePasse));

/*##################### TEST 4 ###############################*/
$objTest->is($intTestResult, 0, "Test des cridentials de l'utilisateurs recherché");


//Cridentials invalides
$strEmail = "simeon.";
$strMotDePasse = "dqsfcvqqq";
$objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMailEtMotDePasse($strEmail,$strMotDePasse);

/*##################### TEST 5 ###############################*/
$objTest->is($objUtilisateur, null, "Test avec des cridentials invalides");


//On a copier la chaine aleatoire pour eviter des problemes de context null
function getChAleat()
{
  $intLen = 3;
  $strBase= "azertyuiopmlkjhgfdsqwxcvbn";
  $intMax=strlen($strBase)-1;
  $strMotDePasseAleat='';

  mt_srand((double)microtime()*1000000);
  while (strlen($strMotDePasseAleat)<$intLen+1)
    $strMotDePasseAleat.=$strBase{mt_rand(0,$intMax)};

  return $strMotDePasseAleat;
}

function verifierValidite($arrResultatAValider,$arrUtilisateursAvecProfil,$strChampNom, $objEntite, $objOrganismeMindef)
{
  $boolResultatVerification = true;
  
  foreach ($arrResultatAValider as $objUtilisateurCur)
  {
    if ((strstr($objUtilisateurCur->getNom(),$strFieldNom_1)==false) &&
        (strstr($objUtilisateurCur->getPrenom(),$strFieldNom_1)==false) &&
        (strstr($objUtilisateurCur->getEmail(),$strFieldNom_1)==false))
    {
      //Erreur - le resultat est invalid
      return false;
    }

    if ($objUtilisateurCur->getOrganismeMindefId() != $objOrganismeMindef->getId())
    {
      //Erreur - le resultat est invalid
      return false;
    }

    if ($objUtilisateurCur->getEntiteId() != $objEntite->getId())
    {
      //Erreur - le resultat est invalid
      return false;
    }

    //pour des raisons de performance et pour utiliser le fait que $boolResultatVerification=true
    if (!$boolResultatVerification)
    {
      foreach ($arrUtilisateursAvecProfil as $objUtilisateurAvecCeProfil)
      {
        $boolResultatVerification=true;

        if ($objUtilisateurCur->getId() == $objUtilisateurAvecCeProfil->getId())
        {
          //On sort du foreach avec $boolResultatVerification=true;
          break;
        }

        //Serra a false si le dernier test n'est pa valide
        $boolResultatVerification=false;
      }
    }
    
    if (!$boolResultatVerification)
    {
      return false;
    }
  }

  return $boolResultatVerification;
}

?>
