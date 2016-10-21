<?php

/**
 * Action pour la recherche des dossier postdocs
 *
 * @author Alexandre WETTA
 */
class rechercherDossier_postdocsAction extends gridAction {

  public function execute($request) {
    $this->objFormFiltre = new RechercheDossier_postdocFormFilter();

    $objRequeteDoctrine = $this->processFiltre();

    $objRequeteDoctrine = Dossier_postdocTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine, $this->getUser());
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_postdoc');
  }

}
?>
