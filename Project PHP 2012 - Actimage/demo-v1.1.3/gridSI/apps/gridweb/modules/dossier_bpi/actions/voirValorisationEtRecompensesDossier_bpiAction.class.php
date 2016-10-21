<?php

/**
 * Action pour la vue d'un dossier
 * Onglet Valorisation et Recompenses
 * @author Jihad
 */
class voirValorisationEtRecompensesDossier_bpiAction extends gridAction
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
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    //verif que le dossier existe
    if (!$this->objDossierBpi)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }

    // vérification si on n'est pas BPI le dosier est bien partagé ou pas
    if (!$this->getUser()->hasMetier(MetierTable::BPI) && $this->objDossierBpi->getEtatPartageId() != Etat_partageTable::PARTAGE)
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }

    $objUtilisateur = UtilisateurTable::getInstance()->findOneById($this->getUser()->getUtilisateur()->getId());
    if($this->getUser()->hasCredential("COR-BPI"))
    {
      if($objUtilisateur->getEntite_id() != $this->objDossierBpi->getHierarchie_locale_id() ||
                    $objUtilisateur->getEntite_id() != $this->objDossierBpi->getAutorite_decision_id())
      {
        $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
        $this->redirect('dossier_bpi/listerDossier_bpis');
      }
    }
    
    
  }
}
