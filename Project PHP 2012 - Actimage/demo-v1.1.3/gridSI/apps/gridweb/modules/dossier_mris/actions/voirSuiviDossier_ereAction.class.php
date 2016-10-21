<?php

/**
 * Action pour la vue de la description du dossier
 *
 * @author Julien GAUTIER
 */
class voirSuiviDossier_ereAction extends gridAction
{

  public function preExecute()
  {
    if ($this->getRequest()->hasParameter('id'))
    {
      $this->dossierId = $this->getRequestParameter('id');
    } 
    else
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_eres');
    }
  }

  public function execute($request)
  {

    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierEre = Dossier_ereTable::getInstance()->findOneById($this->dossierId);

    //verif que le dossier existe
    if (!$this->objDossierEre)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_eres');
    } else {
      //Conditions pour l'affichage des évaluations
      $this->hasCredentialsEvaluation = ($this->getUser()->hasCredential('SUP-MRIS') || $this->getUser()->hasCredential('USR-MRIS'));
      $this->isProposition = $this->objDossierEre->isProposition();
    }
  }
}
