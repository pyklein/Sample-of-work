<?php

/**
 * Accueil de module
 * @author Gabor JAGER
 */
class indexAction extends sfAction
{
  public function execute($request)
  {
    $this->redirect($this->getModuleName()."/listerDossier_bpis");
  }
}