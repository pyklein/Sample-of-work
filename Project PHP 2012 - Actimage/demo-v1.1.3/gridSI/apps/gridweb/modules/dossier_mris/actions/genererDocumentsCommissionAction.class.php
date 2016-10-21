<?php

/**
 * Description of genererDocumentsCommissionAction
 * @author Gabor JAGER
 */
class genererDocumentsCommissionAction extends gridAction {

  public function preExecute() {
    if (!$this->hasRequestParameter('id')) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerCommissions');
    }
  }

  public function execute($objRequeteWeb) {
    $objUtilArbo = new ServiceArborescence();
    $strCheminBase = $objUtilArbo->getRepertoireFichiersStatiques();
    // télécharger le fiche d'inscription
    if ($objRequeteWeb->hasParameter("inscription")) {
      $strFichier = $objUtilArbo->getFicheInscription();
      $this->redirect("interface/telechargerDocument?path=" . bin2hex($strCheminBase) . "&fichier=" . $strFichier . "&fichier_orig=" . $strFichier);
    }

    // télécharger les grilles d'évaluation
    if ($objRequeteWeb->hasParameter("evaluation")) {
      $strFichier = $objUtilArbo->getGrillesEvaluation();
      $this->redirect("interface/telechargerDocument?path=" . bin2hex($strCheminBase) . "&fichier=" . $strFichier . "&fichier_orig=" . $strFichier);
    }

    // télécharger le fiche de suivi
    if ($objRequeteWeb->hasParameter("suivi")) {
      $strFichier = $objUtilArbo->getFichesSuivi();
      $this->redirect("interface/telechargerDocument?path=" . bin2hex($strCheminBase) . "&fichier=" . $strFichier . "&fichier_orig=" . $strFichier);
    }

    try {
      $objDocumentService = new ServiceDocumentMris();

      // télécharger la lettre d'invitation d'un participant interne
      if ($objRequeteWeb->hasParameter("interne")) {
        $strFichier = $objDocumentService->creerDocumentInvitationInterne($objRequeteWeb->getParameter("id"), $objRequeteWeb->getParameter("interne"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }

      // télécharger la lettre d'invitation d'un participant externe
      else if ($objRequeteWeb->hasParameter("externe")) {
        $strFichier = $objDocumentService->creerDocumentInvitationExterne($objRequeteWeb->getParameter("id"), $objRequeteWeb->getParameter("externe"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }

      // télécharger la lettre d'invitation d'un laboratoire
      else if ($objRequeteWeb->hasParameter("laboratoire")) {
        $strFichier = $objDocumentService->creerDocumentInvitationLaboratoire($objRequeteWeb->getParameter("id"), $objRequeteWeb->getParameter("laboratoire"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }

      // télécharger la lettre d'invitation d'un service
      else if ($objRequeteWeb->hasParameter("service")) {
        $strFichier = $objDocumentService->creerDocumentInvitationService($objRequeteWeb->getParameter("id"), $objRequeteWeb->getParameter("service"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=" . $strFichier);
      }
    } catch (Exception $ex) {
      $this->getUser()->setFlash('erreur', $ex->getMessage());
    }

    $this->strId = $objRequeteWeb->getParameter('id');

    $this->objCommission = CommissionTable::getInstance()->findOneById($this->strId);
    if (!$this->objCommission) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerCommissions');
    }

    $this->arrUtilisateurs = UtilisateurTable::getInstance()->getParticipantsByCommission($this->strId)->execute();
    $this->arrIntervenants = IntervenantTable::getInstance()->getIntervenantsByCommission($this->strId)->execute();
    $this->arrInvitations = InvitationTable::getInstance()->getInvitationsByCommission($this->strId)->execute();
  }

}
