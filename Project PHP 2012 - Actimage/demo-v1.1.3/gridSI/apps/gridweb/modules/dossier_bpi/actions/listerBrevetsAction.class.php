<?php
/**
 * Liste des brevets d'un dossier d'innovation
 *
 * @author Actimage
 */
class listerBrevetsAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_bpi_id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($objRequete) {

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    $objRequeteDoctrine = BrevetTable::getInstance()->retrieveBrevets($this->dossierId);

    $this->processPager($objRequeteDoctrine->orderBy('titre'), 'Brevet');
  }

}
?>
