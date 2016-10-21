<?php

/**
 * Action pour la vue de la description du dossier
 *
 * @author Julien GAUTIER
 */
class exporterDossier_postdocPDFAction extends gridAction
{

  public function execute($request)
  {

    $this->editPDF = true;
    if ($this->getRequest()->hasParameter('id'))
    {
      $this->dossierId = $this->getRequestParameter('id');

      $this->credentials = $this->getUser()->getAttribute('credentials');
      $this->strId = $this->dossierId;
      $this->objDossierPostdoc = Dossier_postdocTable::getInstance()->findOneById($this->dossierId);

      //verif que le dossier existe
      if (!$this->objDossierPostdoc)
      {
        $this->editPDF = false;
      } else {
        //Conditions pour l'affichage des évaluations
        $this->hasCredentialsEvaluation = ($this->getUser()->hasCredential('SUP-MRIS') || $this->getUser()->hasCredential('USR-MRIS'));
        $this->isProposition = $this->objDossierPostdoc->isProposition();
      }
    } else {
      $this->editPDF = false;
    }

  }
}
