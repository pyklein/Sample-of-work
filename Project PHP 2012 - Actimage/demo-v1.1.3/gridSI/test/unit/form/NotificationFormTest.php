<?php
/**Tests unitatires pour NotificationForm
 * Projet : GRID
 * Module : notification
 * Date de création : 04/03/2011
 * Auteur: Jihad Sahebdin
 */

//include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/doctrine.php');

$idMetier=3;
$objTest = new lime_test(3);

$objNotificationFormValide = new NotificationForm();
$objNotificationFormValide->bind(array(
    'metier_id'=>$idMetier,
    'contenu'=>'test test',
    'date_debut'=>date('d/m/Y H:i:s', time() - 86400),
    'date_fin' => date('d/m/Y H:i:s', time() + 86400),
    ));
$objTest->ok($objNotificationFormValide->isValid(),'NotificationForm: Valide');

$objNotificationFormInvalide = new NotificationForm();
$objNotificationFormInvalide->bind(array(
    'metier_id'=>$idMetier,
    'contenu'=>'',
    'date_debut'=>date('d/m/Y H:i:s', time() - 86400),
    'date_fin' => date('d/m/Y H:i:s', time() + 86400),
    
    ));
$objTest->cmp_ok($objNotificationFormInvalide->isValid(),'==',false,'NotificationForm: Contenu vide');

$objNotificationFormDateInvalide = new NotificationForm();
$objNotificationFormDateInvalide->bind(array(
    'metier_id'=>$idMetier,
    'contenu'=>'test test',
    'date_debut'=>date('d/m/Y H:i:s', time() - 86400),
    'date_fin' => date('d/m/Y H:i:s', time() - 86400*2), //date de fin < date de debut
   
    ));
$objTest->cmp_ok($objNotificationFormInvalide->isValid(),'==',false,'NotificationForm: Date de fin invalide');



