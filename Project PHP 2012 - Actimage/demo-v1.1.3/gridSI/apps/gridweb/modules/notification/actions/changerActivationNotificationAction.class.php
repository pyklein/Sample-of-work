<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Activer/Désactiver une notification
 * @author     Jihad Sahebdin
 */
class changerActivationNotificationAction extends gridAction
{
  public function preExecute()
  {
  }

  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $objNotification = NotificationTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objNotification){
     $this->redirect('@non_autorise');
    }
    $this->objMyUser = $this->getUser();
    if ($this->getUser()->hasMetier($objNotification->getMetier()->getIntitule()) || ($objNotification->getMetier()->getEstAdministrateur() && $this->objMyUser->isAdministrateur()))
    {
      $this->changerActivation($request->getParameter('id'),'Notification');
    }
    else
    {
      $this->redirect("@non_autorise");
    }
  }
  public function  postExecute()
  {
  }
}
