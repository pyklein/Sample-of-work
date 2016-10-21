<?php
/**
 * notificationComponents: determine les notifications valides (entre date_debut et date_fin ET actifs)
 * à afficher sur la page d'accueil
 *
 * @author Jihad Sahebdin
 */
class notificationComponents extends sfComponents
{
  public function executeNotification(sfWebRequest $request)
  {
    $this->arrNotifications = NotificationTable::getInstance()->getNotificationsAAfficher();
  }
}

