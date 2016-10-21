<?php

/**
 * Modification d'un labo orphelin (sans service ni organisme)
 *
 * @author Alexandre WETTA
 */
class modifierLaboratoireOrphelinAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {

    $objLabo = LaboratoireTable::getInstance()->findOneById($request->getParameter('id'));

    if ($objLabo) {

      $this->objForm = new LaboratoireOrphelinForm($objLabo);
      if ($request->isMethod('post')) {
        $this->processForm('modifier', 'listerLaboratoireOrphelins');
      }
    } else {
      $this->redirect("@non_autorise");
    }
  }

}
?>
