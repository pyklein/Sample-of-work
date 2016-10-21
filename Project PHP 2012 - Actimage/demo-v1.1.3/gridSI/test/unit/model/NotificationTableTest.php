
<?php
/**Tests unitaires pour NotificationTable
 * Projet : GRID
 * Module : notification
 * Date de création : 04/03/2011
 * Auteur: Jihad Sahebdin
 */
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(7);

//$notification = Doctrine_Core::getTable('Notification')->createQuery()->fetchOne();
$idMetier = 3;
$idCreatedBy = 2;
$objNotification = new Notification();
$objNotification->setMetierId($idMetier);
$objNotification->setContenu('test1 valide');
$objNotification->setDateDebut(date('Y-m-d H:i:s', time() - 86400 ));
$objNotification->setDateFin(date('Y-m-d H:i:s', time() + 86400 ));
$objNotification->setEstActif(true);

$objNotification->save();

$objNotification2 = new Notification();
$objNotification2->setMetierId('1');
$objNotification2->setContenu('test2 passee');
$objNotification2->setDateDebut(date('Y-m-d H:i:s', time() - (86400*5) ));
$objNotification2->setDateFin(date('Y-m-d H:i:s', time() - (86400*2) ));
$objNotification2->setEstActif(true);

$objNotification2->save();

$objNotification3 = new Notification();
$objNotification3->setMetierId($idMetier);
$objNotification3->setContenu('test3 inactif');
$objNotification3->setDateDebut(date('Y-m-d H:i:s', time() - 86400 ));
$objNotification3->setDateFin(date('Y-m-d H:i:s', time() + 86400 ));
$objNotification3->setEstActif(false);

$objNotification3->save();

//getNotificationsAAfficher() affiche les notifications sur la page d'accueil
$objNotificationValide = NotificationTable::getInstance()->getNotificationsAAfficher();

$objDateDebut = $objNotificationValide[0]->getDateDebut();
$objDateFin = $objNotificationValide[0]->getDateFin();
$boolEstActif = $objNotificationValide[0]->getEstActif();


$objTest->cmp_ok($objDateDebut, '<=' , date('Y-m-d H:i:s', time()), '->getNotificationsAfficher(): date de debut est inferieur à la date daujourhui');
$objTest->cmp_ok($objDateFin, '>=' , date('Y-m-d',time()), '->getNotificationsAfficher(): date de debut est superieur à la date daujourhui');
$objTest->cmp_ok($boolEstActif, '==', true,'->getNotificationsAfficher(): la notification est active');

$objTest->cmp_ok($objNotificationValide->count() , '==', 1,'->getNotificationsAfficher(): nombre de notifications "en cours" et "actif" ' );

//retrieveNotifications() récupere toutes les notitifications
$objNotificationAll = NotificationTable::getInstance()->retrieveNotifications();
$objTest->cmp_ok($objNotificationAll->count(), '==', 3, '->retrieveNotifications(): récupère toutes les notifications');

//getNotificationsByMetierId() récupère les notifications selon le metier
$objNotificationMetier = NotificationTable::getInstance()->getNotificationsByMetierId('1');
$objTest->cmp_ok($objNotificationMetier->count(), '==', 1,'->getNotificationsByMetierId(): récupère les notifications selon le metier');
$objNotificationMetier = NotificationTable::getInstance()->getNotificationsByMetierId('100');
$objTest->cmp_ok($objNotificationMetier->count(), '==', 0,'->getNotificationsByMetierId(): récupère les notifications selon le metier');


foreach( NotificationTable::getInstance()->findAll() as $objNotification){
   $objNotification->delete();
}