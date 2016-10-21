<?php
/**
 * Liste des dossiers d'inventions (dossier BPI)
 *
 * @author Actimage
 */
class listerDossier_bpisAction extends gridAction{

  public function execute($objRequete) {

    $this->objFormFiltre = new Dossier_bpiFormFilter();

    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = Dossier_bpiTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine,$this->getUser());
    //$this->processPager($objRequeteDoctrine->orderBy('created_at DESC')->orderBy('numero DESC'), 'Dossier_bpi');
	$objRequeteDoctrine->addOrderBy('numero DESC');
    $this->processPager($objRequeteDoctrine->addOrderBy('created_at DESC'), 'Dossier_bpi');
  }

}
?>
