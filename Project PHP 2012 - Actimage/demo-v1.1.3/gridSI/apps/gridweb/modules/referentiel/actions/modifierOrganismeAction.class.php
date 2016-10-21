<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierOrganismeAction
 *
 * @author William
 */
class modifierOrganismeAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $objOrganisme = OrganismeTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objOrganisme) {
      $this->redirect("@non_autorise");
    }
    $this->objForm = new OrganismeForm(false, $objOrganisme);
    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}

?>
