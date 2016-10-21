<?php


/**
 * Activer une ville
 * @author Gabor JAGER
 */
class changerActivationVilleAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter("id"),'Ville');
  }

  /**
   */
  public function postExecute() {
    
  }

}

