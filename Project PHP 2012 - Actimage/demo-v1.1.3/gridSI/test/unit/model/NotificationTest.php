<?php
/**Tests unitatires pour Notification
 * Projet : GRID
 * Module : notification
 * Date de création : 04/03/2011
 * Auteur: Jihad Sahebdin
 */
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$objTest = new lime_test(1);

$idMetier = 3;
$createdBy = 78;

$objNotificationValide = creerNotification(
        $idMetier,
        'Notification Test 1 en cours et actif',
        date('Y-m-d H:i:s', time() - 86400 ),
        date('Y-m-d H:i:s', time() + 86400 ),
        true,
        $createdBy
        );

$obj = $objNotificationValide->getExtrait();
$objTest->comment('$objNotification->getExtrait');
$objTest->is($obj,"Notification Test 1 en...");

function creerNotification($idMetier, $Contenu, $DateDebut, $DateFin, $EstActif, $CreatedBy)
{
  $objNotification = new Notification();
  $objNotification->setMetierId($idMetier);
  $objNotification->setContenu($Contenu);
  $objNotification->setDateDebut($DateDebut);
  $objNotification->setDateFin($DateFin);
  $objNotification->setEstActif($EstActif);

  return $objNotification;
}