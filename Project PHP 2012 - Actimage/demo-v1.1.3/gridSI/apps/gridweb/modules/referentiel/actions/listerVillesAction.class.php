<?php

/**
 * Liste des villes
 * @author Gabor JAGER, William RICHARDS
 */
class listerVillesAction extends gridAction {

  /**
   */
  public function preExecute() {

  }

  public function execute($objRequeteWeb) {

    $this->objFormFiltre = new VilleFormFilter();
    $objRequeteDoctrine = $this->processFiltre('Departement');
    $this->processPager(VilleTable::getInstance()->orderVilles($objRequeteDoctrine),'Ville',false);
  }

  /**
   */
  public function postExecute() {
    
  }

}

