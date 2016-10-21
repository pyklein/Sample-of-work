<?php

/**
 * Lister les notifications
 * @author     Jihad Sahebdin
 */
class listerNotificationsAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($objRequete)
  {
    $this->objFormFiltre = new NotificationFormFilter();
    $this->objMyUser = $this->getUser();
    $this->boolReinitialiser = true;
    
    $this->arrMetier = MetierTable::getInstance()->getMetiersParUtilisateur($this->getUser()->getUtilisateur()->getId());
    $objRequeteDoctrine = $this->processFiltre();
    $this->processPager($objRequeteDoctrine->orderBy('date_debut DESC'), 'Notification', $objRequete); 
  }

  public function  postExecute()
  {
  }
}
