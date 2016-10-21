<?php

/**
 * Action index
 * @author Gabor JAGER
 */
class indexAction extends sfAction
{
  public function execute($request)
  {
    $this->redirect("utilisateurs/listerUtilisateurs");
  }
}
