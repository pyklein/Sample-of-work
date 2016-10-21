<?php

/**
 * Listing des dossiers de stages ERE
 *
 * @author Jihad
 */
class listerDossier_eresAction extends gridAction {

  public function execute($objRequete) {
    
    $this->objFormFiltre = new Dossier_ereFormFilter();

    $objRequeteDoctrine = $this->processFiltre() ;
    
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_ere');
  }

}
?>
