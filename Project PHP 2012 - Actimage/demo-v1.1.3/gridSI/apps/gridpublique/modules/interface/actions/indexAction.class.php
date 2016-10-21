<?php

/**
 * Accueil
 * @author Gabor JAGER
 */
class indexAction extends sfAction
{
  /**
   */
  public function preExecute()
  {
  }


  public function execute($request)
  {
    $this->redirect("dossier_mip/listerDossier_mip_publiques");
  }


  /**
   */
  public function postExecute()
  {
  }
}

