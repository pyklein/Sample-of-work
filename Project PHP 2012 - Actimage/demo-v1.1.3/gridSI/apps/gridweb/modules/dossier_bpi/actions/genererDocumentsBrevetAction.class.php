<?php

/**
 * Action pour la page de génération des documents d'un brevet
 *
 * @author Actimage
 */
class genererDocumentsBrevetAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('id')) {
      $this->brevetId = $this->getRequestParameter('id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {

    $this->objBrevet = BrevetTable::getInstance()->findOneById($this->brevetId);
    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById( $this->objBrevet->getDossierBpiId());
  }

}
?>
