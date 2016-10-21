<?php

/**
 * Suppression d'une remarque d'un dossier d'innovation
 *
 * @author Alexandre WETTA
 */
class supprimerRemarque_bpiAction extends gridAction {

  public function preExecute() {
    
    if (!$this->getRequest()->hasParameter('id')) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
    
  }

  public function execute($objRequeteWeb) {

    $objRemarque = Remarque_bpiTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objRemarque) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }

    $this->strContenant = 'dossier_bpi_id';
    $this->idContenant = $objRemarque->getDossierBpiId();

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->idContenant);

    if ($objRequeteWeb->isMethod('post')) {
      $objRemarque->delete();
      $this->getUser()->setFlash('succes', libelle('msg_remarque_suppression_reussie'));
      $this->redirect('dossier_bpi/listerRemarque_bpis?'.$this->strContenant.'=' . $this->idContenant);
    }
  }

}
?>
