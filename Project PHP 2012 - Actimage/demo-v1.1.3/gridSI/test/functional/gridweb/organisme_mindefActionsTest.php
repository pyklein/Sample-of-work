<?php
/**Tests fonctionnelles pour organisme_mindef
 * Projet : GRID
 * Module : referentiel
 * Date de création : 09/03/2011
 * Auteur: Alexandre WETTA
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

//Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');

$browser = new sfTestFunctional(new sfBrowser());

//on essaye de s'authentifier
$browser->info('1 - Page Authentification')->
  get('authentification/seconnecter')->
        //on check si on est sur la bonne page
  with('request')->begin()->
    isParameter('module', 'authentification')->
    isParameter('action', 'seconnecter')->
 end()->

 // on remplit les 2 champs et on valide le tout
 setField('utilisateur_login[email]', 'gabor.jager@actimage.com')->
 setField('utilisateur_login[mot_de_passe]', 'actimage')->
click('S\'identifier')->

// on check si il y a une redirection et on la suit
info('1.1 - Redirection')->
 with('response')->isRedirected()->
    followRedirect()->

// check si tout va bien
info('1.2 - Statut OK')->
with('response')->begin()->
    isStatusCode(200)->

end();

//// on va sur la page listage des organisme MINDEF une première fois à cause de l'erreur 500
//$browser->info('2 - Page listage des organismes MINDEF')->
//  get('referentiel/listerOrganisme_mindefs')->
//  with('request')->begin()->
//    isParameter('module', NULL)->
//    isParameter('action', NULL)->
//
////  info('  check bonne page')->
////  with('response')->begin()->
////    checkElement('body', '/<h2>/i')->
//
//  end();

// on vient sur la page de listage des organisme MINDEF avec un clic à partir du menu
$browser->info('3 - Clic sur le menu pour afficher les organismes MINDEF')->

  get('referentiel/listerOrganisme_mindefs')->
//  click("Gérer les organismes MINDEF")->

   // on check si on est bien dans dans le bon module et la bonne action
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'listerOrganisme_mindefs')->
 end()->

  // on check si tout va bien
  info('3.1 Check de la page')->
  with('response')->begin()->
    isStatusCode(200)->
  end();

// on clique sur le seul lien "activer" de l'organisme mindef test
$browser->info('4 - Activation organisme MINDEF')->
        
   get('referentiel/changerActivationOrganisme_mindef/id/3')->
   with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'changerActivationOrganisme_mindef')->
  end()->

  // on check la redirection
  info('4.1 - Redirection')->
  with('response')->isRedirected()->
    followRedirect()->

  // on check si l'activation est bonne grâce au message
  info('4.2 Check de l activation')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.succesMessage')->
  end();

// on essage de desactiver un organisme (le premier de la liste)
$browser->info('5 - Desactivation organisme MINDEF')->
   get('referentiel/changerActivationOrganisme_mindef/id/3')->
   with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'changerActivationOrganisme_mindef')->
  end()->

  // on suit la redirection
  info('5.1 - Redirection')->
  with('response')->isRedirected()->
    followRedirect()->

  // on check si tout va bien avec le statusCode 200 et le message
  info('5.2 Check de la desactivation')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.succesMessage')->
  end();

// on essaye de creer un organisme MINDEF sans les erreurs
//$browser->info('6 - Creation d un organisme MINDEF')->
//  info('6.1 - Creation sans erreur')->
//
//  // on va sur la page pour creer un organisme MINDEF
//  get('referentiel/creerOrganisme_mindef')->
//  with('request')->begin()->
//    isParameter('module', 'referentiel')->
//    isParameter('action', 'creerOrganisme_mindef')->
//  end()->
//
//  // on remplit les champ et on valide en cliquant sur Ajouter
//  setField('organisme_mindef[intitule]', 'Renseignements')->
//  setField('organisme_mindef[abreviation]', 'RG')->
//  click('Ajouter')->
//
//  // on suit la redirection
//  info('6.2 - Redirection')->
//  with('response')->isRedirected()->
//    followRedirect()->
//
//  // on check si tout va bien
//  info('6.3 - Statut OK')->
//  with('response')->begin()->
//    isStatusCode(200)->
// end();

// on va creer 2 organismes avec un champ manquant
$browser->info('7 - Creation d un organisme MINDEF avec erreur')->
  info('7.1 - Creation sans Intitule')->

  // on va sur la bonne page
  get('referentiel/creerOrganisme_mindef')->
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'creerOrganisme_mindef')->
  end()->

  // on remplit le champ "abreviation" seulement
  setField('organisme_mindef[intitule]', '')->
  setField('organisme_mindef[abreviation]', 'RG')->
  click('Ajouter')->

 // on regarde si il y a bien une erreur lors de la validation du formulaire
 info('7.2 - Statut Form sans Intitule')->
  with('form')->begin()->
   hasErrors(true)->
 end()->

  // creation de l organisme MINDEF sans abreviation
  info('7.3 - Creation sans Abreviation')->

  // on va sur la page de création d'un organisme MINDEF
  get('referentiel/creerOrganisme_mindef')->
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'creerOrganisme_mindef')->
  end()->

   // on remplit le champ "intitule" seulement et on laisse le champ abreviation vide
  setField('organisme_mindef[intitule]', 'Renseignement')->
  setField('organisme_mindef[abreviation]', '')->
  click('Ajouter')->

  // on check si il y a bien une erreur lors de la validation du formulaire
 info('7.4 - Statut Form sans Abreviation')->
  with('form')->begin()->
   hasErrors(true)->
 end();

// modification d'un organisme MINDEF
$browser->info('8 - Modification d un organisme MINDEF')->
  info('8.1 - Modification sans changement')->

        // on va sur la bonne page
  get('referentiel/listerOrganisme_mindefs')->
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'listerOrganisme_mindefs')->
  end()->

  // on va modifier l'organisme MINDEF avec l'id 3
  get('referentiel/modifierOrganisme_mindef/id/3')->
   with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'modifierOrganisme_mindef')->
  end()->

         // on clique pour valider le formulaire
   click('Modifier')->

         // on suit la redirection
  info('8.2 - Redirection')->
  with('response')->isRedirected()->
    followRedirect()->

  // on check si tout va bien
  info('8.3 - Statut OK')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.succesMessage')->
  end();


// modification d'un organisme MINDEF avec des erreurs
$browser->info('9 - Modification d un organisme MINDEF avec erreurs')->
    info('9.1 - Modification sans intitule')->

        // on va sur la bonne page
  get('referentiel/listerOrganisme_mindefs')->
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'listerOrganisme_mindefs')->
  end()->

  // on va modifier l'organisme MINDEF avec l'id 3
  get('referentiel/modifierOrganisme_mindef/id/3')->
   with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'modifierOrganisme_mindef')->
  end()->

         // on clique pour valider le formulaire
   setField('organisme_mindef[intitule]', '')->
   click('Modifier')->

  info('9.2 - Statut Form sans Intitule')->
  with('form')->begin()->
   hasErrors(true)->
 end()->
      info('9.3 - Modification sans abreviation')->
         // on va sur la bonne page
  get('referentiel/listerOrganisme_mindefs')->
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'listerOrganisme_mindefs')->
  end()->

  // on va modifier l'organisme MINDEF avec l'id 3
  get('referentiel/modifierOrganisme_mindef/id/3')->
   with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'modifierOrganisme_mindef')->
  end()->

         // on clique pour valider le formulaire
   setField('organisme_mindef[abreviation]', '')->
   click('Modifier')->

  info('9.2 - Statut Form sans Intitule')->
  with('form')->begin()->
   hasErrors(true)->

  end();


//$browser->info('2 - Page Creation d un organisme MINDEF')->
//
//  get('referentiel/creerOrganisme_mindef/index')->
//   with('request')->begin()->
//    isParameter('module', 'referentiel')->
//    isParameter('action', 'creerOrganisme_mindef')->
//  end()->
//
//
//with('request')->begin()->
//  isParameter('module', 'referentiel')->
//  isParameter('action', 'creerOrganisme_mindef')->
//end()->
//
////   with('response')->begin()->
////    info('  check bonne page')->
////      //checkElement('input[id="Ajouter"][value=Ajouter]', true)->
////      checkElement('body', '/<h2>/i')->
////  end()->
//
//  click('Ajouter', array('organisme_mindef' => array(
//    'intitule'      => 'Marine',
//    'abreviation'          => 'MA',
//  )))->
//
//  with('request')->begin()->
//    isParameter('module', 'referentiel')->
//    isParameter('action', 'creerOrganisme_mindef')->
//  end()
//;

?>
