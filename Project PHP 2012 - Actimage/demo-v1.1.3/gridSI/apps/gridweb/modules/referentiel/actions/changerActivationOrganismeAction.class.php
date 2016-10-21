<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of changerActivationGradeAction
 *
 * @author William
 */
class changerActivationOrganismeAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($objRequeteWeb) {
    $this->changerActivation($objRequeteWeb->getParameter('id'), 'Organisme');
  }

}

?>
