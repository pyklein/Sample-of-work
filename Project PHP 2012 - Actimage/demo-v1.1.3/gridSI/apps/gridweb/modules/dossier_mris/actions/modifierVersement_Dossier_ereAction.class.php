<?php

/**
 * Action pour modifier un versement
 *
 * @author Jihad
 */
class modifierVersement_Dossier_ereAction extends gridAction{
  public function execute($objRequeteWeb) {

    $total = 0;
    $reserve = 0;
    $this->conventionCollective = false;

    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }

    $objVersement = Versement_dossier_ereTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objVersement){
      $this->redirect('@non_autorise');
    }

    if($objVersement->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'Dossier_ere';
      $this->idContenant = $objVersement->getDossierEreId();
    }
    else
    {
      $this->redirect('@non_autorise');
    }

    //recherche du dossier
    $objDossier = Dossier_ereTable::getInstance()->findOneById($this->idContenant);
    $this->objDossier = $objDossier;
    
    if ($objDossier)
    {
      //on cherche s'il y a une convention pour ce dossier
      $this->objConvention = Convention_dossier_ereTable::getInstance()->findOneByDossierEreId($this->idContenant);

      // s'il existe déjà une convention on utilise celle ci sinon on cherche s'il existe une convention collective
      if ($this->objConvention)
      {
        $this->conventionCollective = true;
      }
      else
      {
        //Recherche d'une convention collective (convention avec un organisme)
        $queryConventionAvecOrganisme = Convention_organismeTable::getInstance()->rechercheConventionCollectiveParDate($objDossier->getCreatedAt(), $objDossier->getOrganismeId(), $this->strContenant);

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

        $this->arrVersements = Versement_dossier_ereTable::getInstance()->getVersementByDossierId($this->idContenant);
        foreach($this->arrVersements as $objVersements)
        {
          $total += $objVersements->getMontantVersement();
        }
        $reserve = ($this->objConvention->getMontant() - $total) + $objVersement->getMontantVersement() ;

        $this->objForm = new Versement_dossier_ereForm($reserve ,$objVersement);

        if ($objRequeteWeb->isMethod('post')){
          $this->processForm('modifier',"modifierFinancement_Dossier_ere?dossier_id=" . $this->idContenant);
        }
      }
    }
  }

}
?>
