<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerServicesAction
 *
 * @author William
 */
class listerServicesAction extends gridAction{
  public function execute($request) {
    if ($request->hasParameter('organisme')){
    $this->objOrganisme = OrganismeTable::getInstance()->findOneById($request->getParameter('organisme'));
    if (!$this->objOrganisme){
      $this->redirect('@non_autorise');
    }
    $objRequeteDoctrine = ServiceTable::getInstance()->retrieveByRelationId($request->getParameter('organisme'));
    $this->processPager($objRequeteDoctrine->orderBy('intitule'), 'Service');
    }else {
      $this->redirect('@non_autorise');
    }
  }

}
?>
