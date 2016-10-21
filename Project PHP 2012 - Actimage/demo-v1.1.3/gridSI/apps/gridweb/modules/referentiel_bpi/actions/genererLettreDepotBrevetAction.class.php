<?php

/**
 * Génération des lettres pour les brevets
 *
 * @author Alexandre WETTA
 */
class genererLettreDepotBrevetAction extends gridAction {

  public function preExecute() {
    if (!($this->getRequest()->hasParameter('inventeur') || $this->getRequest()->hasParameter('entite'))
            && !$this->getRequest()->hasParameter('id')
             && !$this->getRequest()->hasParameter('dossier') ) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request) {

    try {
      $objDocumentService = new ServiceDocumentBpi();

      // télécharger la lettre pour un innnovateur
      if ($request->hasParameter("inventeur")) {
        $strFichier = $objDocumentService->creerLettreDepotBrevetHorsDga($request->getParameter("inventeur"), $request->getParameter("id"), $request->getParameter("dossier"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      } else if($request->hasParameter("entite")){
        $strFichier = $objDocumentService->creerLettreDepotBrevetDga($request->getParameter("id"), $request->getParameter("dossier"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      } else {
        $this->redirect("dossier_bpi/listerBrevets");
      }
    } catch (Exception $ex) {
      $this->getUser()->setFlash('erreur', $ex->getMessage());
      $this->redirect("dossier_bpi/genererDocumentsBrevet?id=".$request->getParameter("id"));
    }
  }

}
