<?php

/**
 * Activer un organisme Mindef
 *
 * @author Actimage
 */
class changerActivationOrganisme_mindefAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Organisme_mindef');
  }

  public function postExecute() {

  }
}
?>
