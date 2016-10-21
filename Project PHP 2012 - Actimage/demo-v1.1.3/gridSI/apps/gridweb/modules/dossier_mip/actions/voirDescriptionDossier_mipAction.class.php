<?php

/**
 * Action pour la vue de la description du dossier
 *
 * @author Actimage
 */
class voirDescriptionDossier_mipAction extends gridAction
{

  public function preExecute()
  {
    if ($this->hasRequestParameter('id'))
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
    
    // vérification si on n'est pas MIP le dosier est bien partagé ou pas
    if (!$this->getUser()->hasMetier(MetierTable::MIP) && $this->objDossierMip->getEtatPartageId() != Etat_partageTable::PARTAGE)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mip/listerDossier_mips');
    }

  }
}
