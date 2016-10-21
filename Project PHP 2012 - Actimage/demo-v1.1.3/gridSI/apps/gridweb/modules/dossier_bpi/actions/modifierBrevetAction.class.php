<?php

/**
 * Action pour la modification d'un brevet
 *
 * @author Actimage
 */
class modifierBrevetAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('id')) {
      $this->brevetId = $this->getRequestParameter('id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

   public function execute($request) {

    //recherche du dossier BPI
    $this->objBrevet = BrevetTable::getInstance()->findOneById($this->brevetId);
    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->objBrevet->getDossierBpiId());

    if ($this->objBrevet) {
      $objBrevet = $this->objBrevet;
      $this->objForm = new BrevetForm($this->objDossier->getId(), $objBrevet);

      //POST du formulaire
      if ($request->isMethod('post')) {
        $this->processForm('modifier', 'listerBrevets?dossier_bpi_id='.$this->objDossier->getId());
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}
?>
