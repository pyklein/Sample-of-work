<?php

/**
 * Modification d'une redevance
 *
 * @author Actimage
 */
class modifierRedevanceAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('id')) {
      $this->redevanceId = $this->getRequestParameter('id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {

    //recherche du dossier BPI
    $this->objRedevance = RedevanceTable::getInstance()->findOneById($this->redevanceId);
    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->objRedevance->getDossierBpiId());

    if ($this->objRedevance) {
      $objRedevance = $this->objRedevance;
      $this->objForm = new RedevanceForm($this->objDossier->getId(), $objRedevance);

      //POST du formulaire
      if ($request->isMethod('post')) {
        $this->processForm('modifier', 'listerRedevances?dossier_bpi_id='.$this->objDossier->getId());
      }
    } else {
      $this->redirect('@non_autorise');
    }
    
  }

}
?>
