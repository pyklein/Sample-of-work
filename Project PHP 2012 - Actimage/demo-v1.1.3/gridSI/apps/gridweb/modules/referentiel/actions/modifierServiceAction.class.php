<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modiferServiceAction
 *
 * @author William
 */
class modifierServiceAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($objRequeteWeb) {
    $objService = ServiceTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objService) {
      $this->redirect("@non_autorise");
    }
    $this->idContenant = $objRequeteWeb->getParameter('organisme');
    $this->objForm = new ServiceForm($objService);
    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('modifier', 'listerServices?organisme=' . $this->idContenant);
    }
  }

}

?>
