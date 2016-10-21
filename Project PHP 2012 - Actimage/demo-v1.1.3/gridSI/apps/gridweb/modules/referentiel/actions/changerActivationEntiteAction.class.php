<?php

/**
 * Activé une entité
 *
 * @author Actimage
 */
class changerActivationEntiteAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'), 'Entite');
  }

  public function postExecute() {
    
  }

}

?>
