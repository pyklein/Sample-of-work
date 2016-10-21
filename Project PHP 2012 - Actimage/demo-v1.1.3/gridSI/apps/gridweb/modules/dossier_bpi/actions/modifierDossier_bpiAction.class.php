<?php

class modifierDossier_bpiAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('id')) {
      $strDossierId = $this->getRequestParameter('id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {
    $this->strId = $request->getParameter('id');
    $objDossier = Dossier_bpiTable::getInstance()->findOneById($this->strId);
    if (!$objDossier) {
      $this->redirect("@non_autorise");
    }
    if (!$objDossier->getEstActif()){
      $this->redirect("@non_autorise");
    }
    $this->objForm = new Dossier_bpiForm($objDossier);
    if ($request->isMethod('post')) {
      $this->processForm('modifier', null, false);
    }
  }

}
