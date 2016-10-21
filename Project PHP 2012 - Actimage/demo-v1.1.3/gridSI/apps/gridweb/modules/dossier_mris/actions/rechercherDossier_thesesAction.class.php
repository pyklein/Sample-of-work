<?php

/**
 * Action pour la recherche des dossiers de thèse
 *
 * @author Alexandre WETTA
 */
class rechercherDossier_thesesAction extends gridAction {

  public function execute($request) {
    $this->objFormFiltre = new RechercheDossier_theseFormFilter();

    $objRequeteDoctrine = $this->processFiltre();

    $objRequeteDoctrine = Dossier_theseTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine,$this->getUser());
    $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'), 'Dossier_these');
  }

}
?>
