<?php

/**
 * Modification d'une remarque d'un dossier BPI
 *
 * @author Alexandre WETTA
 */
class modifierRemarque_bpiAction extends gridAction {

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

    $this->objForm = new Remarque_bpiForm($objRemarque);

    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('modifier', 'listerRemarque_bpis?' . $this->strContenant . '=' . $this->idContenant);
    }
  }

}
?>
