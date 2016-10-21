<?php

/**
 * Financement d'un dossier de thèse
 *
 * @author Jihad
 */
class modifierFinancement_Dossier_theseAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_id')) {
      $this->dossierId = $this->getRequest()->getParameter('dossier_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_theses');
    }
  }

  public function execute($request) {

    $this->type_dossier = "Dossier_these";
    $this->conventionCollective = false ;
    $total = 0;
    $reserve = 0;

    //recherche du dossier
    $objDossier = Dossier_theseTable::getInstance()->findOneById($this->dossierId);
    

    if ($objDossier)
    {
      $this->objDossier = $objDossier;
      
      //on cherche s'il y a une convention pour ce dossier
      $this->objConvention = Convention_dossier_theseTable::getInstance()->findOneByDossierTheseId($this->dossierId);

      // s'il existe déjà une convention on utilise celle ci sinon on cherche s'il existe une convention collective
      if ($this->objConvention)
      {
        $this->conventionCollective = true;
      } 
      else
      {
        //Recherche d'une convention collective (convention avec un organisme)
        $queryConventionAvecOrganisme = Convention_organismeTable::getInstance()->rechercheConventionCollectiveParDate($objDossier->getCreatedAt(), $objDossier->getOrganismeId(), $this->type_dossier,$objDossier->getTypeConventionOrganismeId());

        if ($queryConventionAvecOrganisme->count() != 0)
        {
          $this->conventionCollective = true ;
          $arrConvention = $queryConventionAvecOrganisme->execute();
          $this->objConvention = $arrConvention[0];
        } 
        else
        {
          $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
        }
      }

      if($this->conventionCollective)
      {
        $objVersement = new Versement_dossier_these();
        $objVersement->setDossierTheseId($this->dossierId);

        $this->arrVersements = Versement_dossier_theseTable::getInstance()->getVersementByDossierId($this->dossierId);

        foreach($this->arrVersements as $objVersements)
        {
          $total += $objVersements->getMontantVersement();
        }
        $reserve = $this->objConvention->getMontant() - $total;


        $this->objForm = new Versement_dossier_theseForm($reserve,$objVersement);

        if ($request->isMethod('post'))
        {
          $this->processForm('creer', "modifierFinancement_Dossier_these?dossier_id=" . $this->dossierId);
        }

        $this->arrVersements = Versement_dossier_theseTable::getInstance()->getVersementByDossierId($this->dossierId);
        
      }
      
    } 
    
    else
    {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_theses');
    }
  }

}
?>
