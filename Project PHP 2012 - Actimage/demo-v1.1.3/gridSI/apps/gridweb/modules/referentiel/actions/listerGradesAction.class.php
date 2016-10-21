<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerGradesAction
 *
 * @author William
 */
class listerGradesAction extends gridAction {

  public function preExecute() {
    parent::preExecute();
  }

  public function execute($objRequeteWeb) {
    $this->objFormFiltre = new GradeFormFilter();
    $objRequeteDoctrine = $this->processFiltre('Organisme_mindef');
    $this->processPager($objRequeteDoctrine->orderBy('intitule'), 'Grade');
    
  }

  public function postExecute() {
    parent::postExecute();
  }

}

?>
