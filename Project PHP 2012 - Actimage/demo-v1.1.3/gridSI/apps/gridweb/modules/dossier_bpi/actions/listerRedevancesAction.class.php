<?php

/**
 * liste des redevances d'un dossier BPI
 *
 * @author Actimage
 */
class listerRedevancesAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_bpi_id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    $objRequeteDoctrine = RedevanceTable::getInstance()->retrieveRedevances($this->dossierId);

    $this->processPager($objRequeteDoctrine, 'Redevance');
  }

}
?>
