<?php

class modifierDossier_mipAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('id')) {
      $strDossierId = $this->getRequestParameter('id');
      if (($this->getUser()->hasCredential('USR-MIP'))
              && (Dossier_mipTable::getInstance()->findOneById($strDossierId)->getPiloteId() != $this->getUser()->getUtilisateur()->getId())) {
        $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
        $this->redirect('dossier_mip/listerDossier_mips');
      }
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mip/listerDossier_mips');
    }
  }

  public function execute($request) {
    $this->strId = $request->getParameter('id');
    $objDossier = Dossier_mipTable::getInstance()->findOneById($this->strId);
    if (!$objDossier) {
      $this->redirect("@non_autorise");
    }
    $this->objForm = new Dossier_mipForm($objDossier);

    $this->arrFiles = $request->getFiles("dossier_mip");

    if ($request->isMethod('post')) {
      $this->processForm('modifier', $this->getActionName() . "?id=" . $this->strId, true);
    }
  }

}
