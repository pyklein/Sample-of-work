<?php

/**
 * Action pour changer l'etat (Actif/inactif) d'un brevet
 *
 * @author Actimage
 */
class changerActivationBrevetAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_bpi_id')&& $this->getRequest()->hasParameter('id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'), 'Brevet', $this->dossierId, 'dossier_bpi_id');
  }

  public function postExecute() {

  }

}
?>
