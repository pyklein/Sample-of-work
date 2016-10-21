<?php

/**
 * Ajout d'un brevet dans un dossier d'invention
 *
 * @author Actimage
 */
class creerBrevetAction extends gridAction {

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
      $objBrevet = new Brevet();
      $objBrevet->setDossierBpiId($this->dossierId);
      

      //On cherche la phase de dépot racine
      $objPhaseDepot = Phase_depot_brevetTable::getInstance()->findRoot();
      $objBrevet->setPhaseDepotBrevetId($objPhaseDepot->getId());

      $this->objForm = new BrevetForm($this->objDossier->getId(), $objBrevet);

      //POST du formulaire
      if ($request->isMethod('post')) {
        $this->processForm('creer', 'listerBrevets?dossier_bpi_id='.$this->objDossier->getId());
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}
?>
