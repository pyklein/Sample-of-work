<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Modifier une notification
 * @author     Jihad Sahebdin
 */
class modifierNotificationAction extends gridAction
{
  public function  preExecute()
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
      $intIdUtilisateur = $this->getUser()->getUtilisateur()->getId();
      $arrMetier = MetierTable::getInstance()->getMetiersParUtilisateur($this->getUser()->getUtilisateur()->getId());
      $objNotification->setMetierId($arrMetier[0]);



      $objNotification->setDateDebut(formatDate($objNotification->getDateDebut()));
      $objNotification->setDateFin(formatDate($objNotification->getDateFin()));

      $this->objForm = new NotificationForm($objNotification,array('intIdUtilisateur'=> $intIdUtilisateur));

      if ($request->isMethod('post')) {
        $this->processForm('modifier');
      }
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
