<?php


/**
 * Description of editerDepartementAction
 *
 * @author William
 */
class modifierDepartementAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $objDepartement = DepartementTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objDepartement){
      $this->redirect("@non_autorise");
    }
    $this->objForm = new DepartementForm($objDepartement);
    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}
