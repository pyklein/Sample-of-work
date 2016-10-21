<?php

/**
 * Description of listerLaboratoiresAction
 *
 * @author William
 */
class listerLaboratoiresAction extends gridAction {

  public function preExecute() {
    parent::preExecute();
  }

  public function execute($objRequeteWeb) {
    if ($objRequeteWeb->hasParameter('organisme')) {
      $this->objContenant = OrganismeTable::getInstance()->findOneById($objRequeteWeb->getParameter('organisme'));
      if (!$this->objContenant){
         $this->redirect('@non_autorise');
      }
      $objRequeteDoctrine = LaboratoireTable::getInstance()->retrieveByOrganismeId($objRequeteWeb->getParameter('organisme'),true);
      $this->processPager($objRequeteDoctrine, 'Laboratoire');
      $this->strModelContenant = 'organisme';
    } elseif ($objRequeteWeb->hasParameter('service')) {
      $this->objContenant = ServiceTable::getInstance()->findOneById($objRequeteWeb->getParameter('service'));
      if (!$this->objContenant){
         $this->redirect('@non_autorise');
      }
      $objRequeteDoctrine = LaboratoireTable::getInstance()->retrieveByServiceId($objRequeteWeb->getParameter('service'));
      $this->processPager($objRequeteDoctrine, 'Laboratoire');
      $this->objOrganisme = $this->objContenant['Organisme'];
      $this->strModelContenant = 'service';
    } else {
      $this->redirect('@non_autorise');
    }
  }

  public function postExecute() {
    parent::postExecute();
  }

}

?>
