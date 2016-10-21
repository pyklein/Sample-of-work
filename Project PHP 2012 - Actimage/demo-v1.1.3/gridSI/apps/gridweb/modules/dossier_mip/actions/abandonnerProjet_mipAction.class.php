<?php

/**
 * Description of basculerProjet_mipAction
 *
 * @author William
 */
class abandonnerProjet_mipAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_mip')) {
      $strDossierId = $this->getRequestParameter('dossier_mip');
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
    $this->strId = $request->getParameter('dossier_mip');
    $this->objDossier = Dossier_mipTable::getInstance()->findOneById($this->strId);
    if (!$this->objDossier) {
      $this->redirect("@non_autorise");
    }

    if ($request->isMethod('post')){
      try {
        $this->objDossier->abandonner();
        $this->getUser()->setFlash('succes', libelle('msg_abandonner_projet_mip_succes',array($this->objDossier->getTitre())));
      } catch (Exception $ex) {
        $this->getUser()->setFlash('erreur', libelle('msg_abandonner_projet_mip_erreur',array($this->objDossier->getTitre())));
      }
      $this->redirect("dossier_mip/modifierDossier_mip?id=" .$this->strId);
    }
  }

}
?>
