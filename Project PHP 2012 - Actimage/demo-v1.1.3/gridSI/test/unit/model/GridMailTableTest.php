<?php
/**
 * Tests Unitaires pour MailTable
 * Projet : GRID
 * Module : email
 * Date de création : 01/03/2011
 * Auteur: William Richards
 */
require_once(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(1);
//Test si retrieveMailsAEnvoyer retourne bien un mail défini comme 'à envoyer'

$objAdmin = Doctrine_Core::getTable('Utilisateur')->createQuery()->fetchOne();

$objEmailEnvoye = new Mail();
$objEmailAEnvoye = new Mail();
$objEmailAEnvoyeFutur = new Mail();

$objEmailAEnvoyeFutur->setSujet('A envoyer demain');
$objEmailAEnvoyeFutur->setDestinataire('mail@test.fr');
$objEmailAEnvoyeFutur->setMessage('Hello World');
$objEmailAEnvoyeFutur->setUtilisateurCreatedBy($objAdmin);
$objEmailAEnvoyeFutur->setDateEnvoi(date('Y-m-d H:i:s', time() + 86400 ));
$objEmailAEnvoyeFutur->setStatutId('1');
$objEmailAEnvoyeFutur->setNombreTentative('1');
$objEmailAEnvoyeFutur->save();

$objEmailEnvoye->setSujet('Déjà envoyé');
$objEmailEnvoye->setDestinataire('mail@test.fr');
$objEmailEnvoye->setMessage('Hello World');
$objEmailEnvoye->setUtilisateurCreatedBy($objAdmin);
$objEmailEnvoye->setDateEnvoi(date('Y-m-d H:i:s'));
$objEmailEnvoye->setStatutId('2');
$objEmailEnvoye->setNombreTentative('0');
$objEmailEnvoye->save();

$objEmailAEnvoye->setSujet('A envoyer maintenant');
$objEmailAEnvoye->setDestinataire('mail@test.fr');
$objEmailAEnvoye->setMessage('Hello World');
$objEmailAEnvoye->setUtilisateurCreatedBy($objAdmin);
$objEmailAEnvoye->setDateEnvoi(date('Y-m-d H:i:s'));
$objEmailAEnvoye->setStatutId('1');
$objEmailAEnvoye->setNombreTentative('1');
$objEmailAEnvoye->save();

$objEmailsRecuperes = MailTable::getInstance()->retrieveMailsAEnvoyer();
if ($objEmailsRecuperes->count() == 1){ 
  $strSujet = $objEmailsRecuperes[0]->getSujet();
} else {
  $strSujet = '';
}
$objTest->is($strSujet,'A envoyer maintenant','->retrieveMailsAEnvoyer()
  Renvoi des mails à envoyer à une date non future');

foreach(  MailTable::getInstance()->findAll() as $objEmail){
   $objEmail->delete();
}

?>
