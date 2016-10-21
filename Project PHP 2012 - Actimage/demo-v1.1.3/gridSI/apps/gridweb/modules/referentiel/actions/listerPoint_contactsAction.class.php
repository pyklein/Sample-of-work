<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerPoints_de_contactsAction
 *
 * @author William
 */
class listerPoint_contactsAction extends gridAction {

  public function preExecute() {
    parent::preExecute();
  }

  public function execute($objRequeteWeb) {
    $this->strModelContenant = 'organisme';
    $this->objMetier = $this->getUser()->getUtilisateur()->getProfil()->getMetier();
    $intMetierId = $this->objMetier->getId();
    if ($objRequeteWeb->hasParameter('organisme')) {
      $this->objContenant = OrganismeTable::getInstance()->findOneById($objRequeteWeb->getParameter('organisme'));
      if(!$this->objContenant){
        $this->redirect('@non_autorise');
      }
      $objRequeteDoctrine = Point_contactTable::getInstance()->retrieveByOrganismeIdAndMetierId($objRequeteWeb->getParameter('organisme'),$intMetierId);
      $this->processPager($objRequeteDoctrine, 'Organisme');
      $this->strModelContenant = 'organisme';
    } elseif ($objRequeteWeb->hasParameter('laboratoire')) {
      $this->objContenant = LaboratoireTable::getInstance()->findOneById($objRequeteWeb->getParameter('laboratoire'));
      if(!$this->objContenant){
        $this->redirect('@non_autorise');
      }
      $objRequeteDoctrine = Point_contactTable::getInstance()->retrieveByLaboratoireIdAndMetierId($objRequeteWeb->getParameter('laboratoire'),$intMetierId);
      $this->processPager($objRequeteDoctrine, 'Laboratoire');
      $this->strModelContenant = 'laboratoire';
      $this->objOrganismeContenant = $this->objContenant['Organisme'];
    } elseif ($objRequeteWeb->hasParameter('service')){
      $this->objContenant = ServiceTable::getInstance()->findOneById($objRequeteWeb->getParameter('service'));
      if(!$this->objContenant){
        $this->redirect('@non_autorise');
      }
      $objRequeteDoctrine = Point_contactTable::getInstance()->retrieveByServiceIdAndMetierId($objRequeteWeb->getParameter('service'),$intMetierId);
      $this->processPager($objRequeteDoctrine, 'Service');
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
