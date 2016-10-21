<?php
/**Tests fonctionnelles pour organisme_mindef
 * Projet : GRID
 * Module : referentiel
 * Date de création : 14/03/2011
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


$browser->info('2 - afficher les Entites')->
  get('referentiel/listerEntites')->

   // on check si on est bien dans dans bon module et la bonne action
  with('request')->begin()->
    isParameter('module', 'referentiel')->
    isParameter('action', 'listerEntites')->
 end()->

  // on check si tout va bien
  info('2.1 Check de la page')->
  with('response')->begin()->
    isStatusCode(200)->
  end();

// on clique sur le seul lien "activer"
//$browser->info('3 - Clic sur desactivation Entite')->
//   click('Désactiver')->
//   with('request')->begin()->
//    isParameter('module', 'referentiel')->
//    isParameter('action', 'changerActivationEntite')->
//  end()->
//
//  // on check la redirection
//  info('3.1 - Redirection')->
//  with('response')->isRedirected()->
//    followRedirect()->
//
//  // on check si l'activation est bonne grâce au message
//  info('4.2 Check de l activation')->
//  with('response')->begin()->
//    isStatusCode(200)->
//    checkElement('div.succesMessage')->
//  end();


?>
