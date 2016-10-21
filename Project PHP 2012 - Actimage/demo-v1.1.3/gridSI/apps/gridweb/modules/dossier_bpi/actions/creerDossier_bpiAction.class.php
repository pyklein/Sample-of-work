<?php

class creerDossier_bpiAction extends gridAction {

  public function execute($request) {
    $objDossier = new Dossier_bpi();
    $this->objForm = new Dossier_bpiForm($objDossier);
    if ($request->isMethod('post')) {
      if($this->processForm('creer','',false))
      {
        $utilFichier = new UtilFichier();
        $serviceArbo = new ServiceArborescence();
        try {
          $utilFichier->isExiste($serviceArbo->getRepertoirePartageDocumentsBpi($objDossier->getRepertoirePartage()));
        } catch (Exception $e){
          $this->getUser()->setFlash('warning', libelle("msg_erreur_creation_dossier_partage"));
        }
        $this->redirect("dossier_bpi/listerDossier_bpis");
      }
    }
  }

}

