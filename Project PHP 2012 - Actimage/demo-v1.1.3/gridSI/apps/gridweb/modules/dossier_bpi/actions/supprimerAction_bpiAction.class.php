<?php


/**
 * Suppression d'un action d'un dossier bpi
 * @author Jihad
 */
class supprimerAction_bpiAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
    $objAction = ActionTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objAction) {
      $this->redirect('@non_autorise');
    }

    $this->strContenant = 'dossier_bpi';
    $this->idContenant = $objAction->getDossierBpiId();

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($objAction->getDossierBpiId());

    if ($objRequeteWeb->isMethod('post')){
      $objAction->delete();
      $this->getUser()->setFlash('succes', libelle("msg_action_bpi_suppression_reussie"));
      $this->redirect("dossier_bpi/actionsDossiers?".$this->strContenant."=".$this->idContenant);
    }
  }

}

?>
