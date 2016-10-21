<?php

/**
 * Export PDF d'un dossier MIP
 * @author Gabor JAGER
 */
class exporterDossier_mipPDFAction extends gridAction
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
      $this->redirect('dossier_mip/listerDossier_mips');
    }
  }

  public function execute($request)
  {
    $this->strId = $this->dossierId;
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->dossierId);

    //verif que le dossier existe
    if (!$this->objDossierMip)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mip/listerDossier_mips');
    }
  }
}
