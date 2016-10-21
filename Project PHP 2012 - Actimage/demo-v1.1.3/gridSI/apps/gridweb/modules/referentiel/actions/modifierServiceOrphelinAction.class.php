<?php

/**
 * Description of modifierServiceOrphelinAction
 *
 * @author Alexandre WETTA
 */
class modifierServiceOrphelinAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {

    $objService = ServiceTable::getInstance()->findOneById($request->getParameter('id'));

    if ($objService) {

      $this->objForm = new ServiceOrphelinForm($objService);
      if ($request->isMethod('post')) {
        $this->processForm('modifier','listerServiceOrphelins');
      }
    } else {
      $this->redirect("@non_autorise");
    }
  }

}
?>
