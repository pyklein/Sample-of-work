<?php

/**
 * Edition d'une action sur un dossier bpi
 *
 * @author Jihad
 */
class modifierAction_bpiAction extends gridAction{
  public function  execute($objRequeteWeb) {
    $this->objUser = $this->getUser();
    
    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }
    $objAction = ActionTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objAction){
      $this->redirect('@non_autorise');
    }

    $this->strContenant = 'dossier_bpi';
    $this->idContenant = $objAction->getDossierBpiId();

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($objAction->getDossierBpiId());

    $this->objForm = new ActionForm($this->objUser,$objAction);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','actionsDossiers?'.$this->strContenant.'='. $this->idContenant);
    }
    
  }

}
?>
