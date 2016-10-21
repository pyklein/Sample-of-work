<?php

/**
 * Listing des dossiers de stages postdoctoraux
 *
 * @author Jihad
 */
class listerDossier_postdocsAction extends gridAction {

  public function execute($objRequete) {
    
    $this->objFormFiltre = new Dossier_postdocFormFilter();

    $objRequeteDoctrine = $this->processFiltre() ;
    
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_postdoc');
  }

}
?>
