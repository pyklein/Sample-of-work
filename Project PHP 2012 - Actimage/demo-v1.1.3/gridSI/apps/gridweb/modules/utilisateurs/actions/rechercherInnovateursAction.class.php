<?php

/**
 * Action pour la recherche des innovateurs 
 *
 * @author Alexandre WETTA
 */
class rechercherInnovateursAction extends gridAction {

  public function preExecute() {

  }

  public function execute($request) {
    $this->objMyUser = $this->getUser();
    $this->objFormFiltre = new InnovateurFormFilter();
    
    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = UtilisateurTable::getInstance()->retrieveInnovateursByProfil($objRequeteDoctrine, $this->objMyUser->getCredentials());
    $this->processPager($objRequeteDoctrine->orderBy('nom ASC'), 'Utilisateur');

  }

}
?>
