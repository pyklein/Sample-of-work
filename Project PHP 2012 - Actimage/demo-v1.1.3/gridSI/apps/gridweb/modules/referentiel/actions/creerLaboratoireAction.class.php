<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creerOrganismeAction
 *
 * @author William
 */
class creerLaboratoireAction extends gridAction {

  public function execute($objRequeteWeb) {
    $objLaboratoire = new Laboratoire();

    if ($objRequeteWeb->hasParameter('organisme')) {
      $this->idContenant = $objRequeteWeb->getParameter('organisme');
      $this->strContenant = 'organisme';
      $objOrganisme = OrganismeTable::getInstance()->findOneById($this->idContenant);
      if (!$objOrganisme || !$objOrganisme->getEstActif()){
        $this->redirect('@non_autorise');
      }
      $objLaboratoire->setOrganisme($objOrganisme);
      $this->objForm = new LaboratoireOrganismeForm($objLaboratoire);
    } elseif ($objRequeteWeb->hasParameter('service')){
      $this->idContenant = $objRequeteWeb->getParameter('service');
      $this->strContenant = 'service';
      $objService = ServiceTable::getInstance()->findOneById($this->idContenant);
      if (!$objService || !$objService->getEstActif()){
        $this->redirect('@non_autorise');
      }
      $objLaboratoire->setService($objService);
      $objLaboratoire->setOrganisme(ServiceTable::getInstance()->findOneById($this->idContenant)->getOrganisme());
      $this->objForm = new LaboratoireServiceForm($objLaboratoire);
    } else {
      $this->redirect('@non_autorise');
    }


    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('creer', 'listerLaboratoires?'.$this->strContenant.'='.$this->idContenant);
    }
  }

}

?>
