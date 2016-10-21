<?php

/**
 * Action pour la génération de documents de la page de validation d'un dossier Mris
 *
 * @author Alexandre WETTA
 */
class genererDocumentsValidationDossierAction extends gridAction {

  public function preExecute() {
    if (!$this->hasRequestParameter('id') || !$this->hasRequestParameter('type') ) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('interface/index');
    }
  }

  public function execute($request) {

    try {
      $objDocumentService = new ServiceDocumentMris();

      // télécharger la lettre de refus
      if ($request->hasParameter("refus")) {
        $strFichier = $objDocumentService->creerDocumentValidationRefus($request->getParameter("id"), $request->getParameter("type"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }
      if ($request->hasParameter("attente")) {
        $strFichier = $objDocumentService->creerDocumentValidationListeAttente($request->getParameter("id"), $request->getParameter("type"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }
      if ($request->hasParameter("acceptation")) {
        $strFichier = $objDocumentService->creerDocumentValidationAcceptation($request->getParameter("id"), $request->getParameter("type"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }
       if ($request->hasParameter("attestation")) {
        $strFichier = $objDocumentService->creerDocumentValidationAttestation($request->getParameter("id"), $request->getParameter("type"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }

      
    } catch (Exception $ex) {
      $this->getUser()->setFlash('erreur', $ex->getMessage());
      $this->redirect("dossier_mris/validerDossier?" .strtolower($request->getParameter("type"))."=". $request->getParameter('id'));
    }


  }

}
?>
