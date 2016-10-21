<?php

/**
 * Export PDF d'un dossier BPI
 * @author Jihad
 */
class exporterDossier_bpiPDFAction extends gridAction
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
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

  public function execute($request)
  {
    $this->strId = $this->dossierId;
    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    //verif que le dossier existe
    if (!$this->objDossierBpi)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }
}
