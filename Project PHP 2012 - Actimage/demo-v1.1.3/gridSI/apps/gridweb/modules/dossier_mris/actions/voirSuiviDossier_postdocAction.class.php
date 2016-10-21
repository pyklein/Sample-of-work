<?php

/**
 * Action pour la vue de la description du dossier
 *
 * @author Julien GAUTIER
 */
class voirSuiviDossier_postdocAction extends gridAction
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
      $this->redirect('dossier_mris/listerDossier_postdocs');
    }
  }

  public function execute($request)
  {

    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierPostdoc = Dossier_postdocTable::getInstance()->findOneById($this->dossierId);

    //verif que le dossier existe
    if (!$this->objDossierPostdoc)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_postdocs');
    } else {
      //Conditions pour l'affichage des évaluations
      $this->hasCredentialsEvaluation = ($this->getUser()->hasCredential('SUP-MRIS') || $this->getUser()->hasCredential('USR-MRIS'));
      $this->isProposition = $this->objDossierPostdoc->isProposition();
    }
  }
}
