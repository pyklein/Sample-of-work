<?php

/**
 * Listing des dossiers de thèse
 *
 * @author Actimage
 */
class listerDossier_thesesAction extends gridAction {

  public function execute($objRequete) {
    
    $this->objFormFiltre = new Dossier_theseFormFilter();

    $objRequeteDoctrine = $this->processFiltre() ;
   
    
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_these');
  }

}
?>
