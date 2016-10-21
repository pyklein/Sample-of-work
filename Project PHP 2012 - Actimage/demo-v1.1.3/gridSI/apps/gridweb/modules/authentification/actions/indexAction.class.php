<?php

/**
 * Action d'authentification
 * @author Gabor JAGER
 */
class indexAction extends sfAction
{
  public function preExecute() {
    $this->logger = sfContext::getInstance()->getLogger();
  }

  public function execute($request)
  {
    if ($this->getUser()->getUtilisateur())
    {
      $this->redirect("@accueil");
    }
    else
    {
      $this->redirect("@seconnecter");
    }
  }

  public function postExecute() {}
}

