<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierLaboratoireAction
 *
 * @author William
 */
class modifierLaboratoireAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($objRequeteWeb) {


    $objLaboratoire = LaboratoireTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objLaboratoire) {
      $this->redirect("@non_autorise");
    }

    if ($objRequeteWeb->hasParameter('organisme')) {
      $this->idContenant = $objRequeteWeb->getParameter('organisme');
      $this->strContenant = 'organisme';
      $this->objForm = new LaboratoireOrganismeForm($objLaboratoire);
    } else {
      $this->idContenant = $objRequeteWeb->getParameter('service');
      $this->strContenant = 'service';
      $this->objForm = new LaboratoireServiceForm($objLaboratoire);
    }


    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('modifier', 'listerLaboratoires?' . $this->strContenant . '=' . $this->idContenant);
    }
  }

}

?>
