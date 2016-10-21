<?php

/**
 * Accueil de notification
 * @author Jihad Sahebdin
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
    $this->redirect("referentiel/index");
  }


  /**
   */
  public function postExecute()
  {
  }
}

