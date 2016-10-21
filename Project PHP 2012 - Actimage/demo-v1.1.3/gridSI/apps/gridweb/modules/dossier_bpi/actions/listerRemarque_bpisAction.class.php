<?php

/**
 * Liste des remarques d'un dossier BPI
 *
 * @author Actimage
 */
class listerRemarque_bpisAction extends gridAction {

  public function execute($objRequeteWeb) {
    //On enregistre l'utilisateur logué
    $this->objUser = $this->getUser();
    //On redirige si on a pas le bon parametre
    if (!$objRequeteWeb->hasParameter('dossier_bpi_id')) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
    $dossierBpiId = $objRequeteWeb->getParameter('dossier_bpi_id');
    //redirection si dossier bpi inexistant
    if (($this->objDossier = Dossier_bpiTable::getInstance()->findOneById($dossierBpiId))) {

      $this->objFormFiltre = new Remarque_bpiFormFilter($dossierBpiId);

      $objRequeteDoctrine = $this->processFiltre('UtilisateurCreatedBy');

      $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'),'Remarque_bpis');

      $objRemarque = new Remarque_bpi();
      $objRemarque['Dossier_bpi'] = Dossier_bpiTable::getInstance()->findOneById($dossierBpiId);
      $this->objForm = new Remarque_bpiForm($objRemarque);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('remarque_bpi')) {
        $this->processForm('creer', 'listerRemarque_bpis?dossier_bpi_id=' . $dossierBpiId);
      }
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

}
?>
