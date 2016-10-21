<?php

/**
 * Action pour la recherche des dossiers ERE
 *
 * @author Alexandre WETTA
 */
class rechercherDossier_eresAction extends gridAction {

  public function execute($request) {
    $this->objFormFiltre = new RechercheDossier_ereFormFilter();

    $objRequeteDoctrine = $this->processFiltre();

    $objRequeteDoctrine = Dossier_ereTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine, $this->getUser());
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_ere');
  }

}
?>
