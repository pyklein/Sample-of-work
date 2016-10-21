<?php

/**
 * Activer une département
 * @author Gabor JAGER
 */
class changerActivationDepartementAction extends gridAction {

  /**
   */
  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Departement');
  }

  /**
   */
  public function postExecute() {
    
  }

}

