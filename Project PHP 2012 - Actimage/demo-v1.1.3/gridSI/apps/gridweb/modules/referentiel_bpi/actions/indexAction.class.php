<?php

/**
 * Accueil de referentiel
 * @author Gabor JAGER
 */
class indexAction extends sfAction
{
  public function execute($request)
  {
    $this->redirect("referentiel/index");
  }
}

