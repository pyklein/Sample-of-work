<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Voir une notification
 *
 * @author     Jihad Sahebdin
 */
class afficherNotificationAction extends sfAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }
    
    $this->objNotification = NotificationTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$this->objNotification){
     $this->redirect('@non_autorise');
    }
  }

  public function  postExecute()
  {
  }

}
