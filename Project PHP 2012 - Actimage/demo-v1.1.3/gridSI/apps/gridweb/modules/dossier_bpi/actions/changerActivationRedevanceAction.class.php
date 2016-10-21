<?php

/**
 * Changement de l'activation d'une redevance
 *
 * @author Actimage
 */
class changerActivationRedevanceAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_bpi_id') && $this->getRequest()->hasParameter('id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'), 'Redevance', $this->dossierId, 'dossier_bpi_id');
  }

}
?>
