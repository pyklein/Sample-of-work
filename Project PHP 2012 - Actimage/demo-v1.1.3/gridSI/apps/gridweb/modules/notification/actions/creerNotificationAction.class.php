<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Ajouter une notification

 * @author     Jihad Sahebdin
 */
class creerNotificationAction extends gridAction
{


  public function execute($request)
  {

    $objNotification = new Notification();
    

    $intIdUtilisateur = $this->getUser()->getUtilisateur()->getId();
    $arrMetier = MetierTable::getInstance()->getMetiersParUtilisateur($this->getUser()->getUtilisateur()->getId());

    $objNotification->setMetierId($arrMetier[0]);
    $this->objForm = new NotificationForm($objNotification,array('intIdUtilisateur'=> $intIdUtilisateur));
    if($request->isMethod('post'))
    {
      $this->processForm('creer');
    }
  }


  
}
