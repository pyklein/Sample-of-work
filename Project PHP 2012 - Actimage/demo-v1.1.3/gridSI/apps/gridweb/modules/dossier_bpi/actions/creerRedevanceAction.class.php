<?php

/**
 * Création d'une redevance
 *
 * @author Actimage
 */
class creerRedevanceAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_bpi_id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {
    //recherche du dossier BPI
    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    if ($this->objDossier) {
      $objRedevance = new Redevance();
      $objRedevance->setDossierBpiId($this->dossierId);


      $this->objForm = new RedevanceForm($this->objDossier->getId(), $objRedevance);

      //POST du formulaire
      if ($request->isMethod('post')) {
        $this->processForm('creer', 'listerRedevances?dossier_bpi_id='.$this->dossierId);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}
?>
