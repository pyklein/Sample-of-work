<?php

/**
 * Actions a mener sur un dossier bpi
 *
 * @author Jihad
 */
class actionsDossiersAction extends gridAction {

  public function execute($objRequeteWeb) {
    //On enregistre l'utilisateur logué
    $this->objUser = $this->getUser();
    
    //On redirige si on a pas le bon parametre
    if (!$objRequeteWeb->hasParameter('dossier_bpi')) {
      $this->redirect('@non_autorise');
    }
    $intIdDossierBpi = $objRequeteWeb->getParameter('dossier_bpi');

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($intIdDossierBpi);
    //redirection si dossier bpi inexistant
    if ($this->objDossier)
    {
      
      $this->objFormFiltre = new ActionFormFilter($intIdDossierBpi);
      $objRequeteDoctrine = $this->processFiltre();
      
      $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'),'Action');

      //Création d'une action d'un dossier
      $objAction = new Action();
      $objAction['Dossier_bpi'] = Dossier_bpiTable::getInstance()->findOneById($intIdDossierBpi);
      
      $this->objForm = new ActionForm($this->objUser,$objAction);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('dossier_bpi'))
      {
        $this->processForm('creer', 'actionsDossiers?dossier_bpi='.$intIdDossierBpi);
      }
    }
    else
    {
      $this->redirect('@non_autorise');
    }
  }

}

?>
