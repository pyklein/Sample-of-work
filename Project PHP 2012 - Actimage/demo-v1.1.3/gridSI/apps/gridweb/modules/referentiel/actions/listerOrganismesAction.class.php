<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerOrganismesAction
 *
 * @author William
 */
class listerOrganismesAction extends gridAction {

  public function preExecute() {
    parent::preExecute();
  }

  public function execute($objRequeteWeb) {
    $this->objFormFiltre = new OrganismeFormFilter();
    $objRequeteDoctrine = $this->processFiltre('Type_organisme');
    $this->processPager($objRequeteDoctrine->orderBy('intitule'), 'Organisme');
  }

  public function postExecute() {
    parent::postExecute();
  }

}

?>
