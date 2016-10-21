<?php
/**
 * Components pour visualiser un dossier MIP
 * @author Gabor JAGER
 */
class dossier_mipComponents extends sfComponents
{
  public function executeVoirCalendrierDossier_mip(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    
    $this->strId = $this->dossierId;
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->dossierId);

    $this->objAvisEtatMajor = Avis_etatmajorTable::getInstance()->findOneByDossierMipId($this->dossierId);
    $this->objSoutien = SoutienTable::getInstance()->findOneByDossierMipId($this->dossierId);
    $this->objRemiseDoc = Remise_documentsTable::getInstance()->findOneByDossierMipId($this->dossierId);
    $this->objTransfertCloture = Transfert_clotureTable::getInstance()->findOneByDossierMipId($this->dossierId);
  }

  public function executeVoirDescriptionDossier_mip(sfWebRequest $request)
  {
    $this->objInnovateurprincipal ="";
    $this->dossierId = $request->getParameter('id');

    $this->boolEstInnovateurDuDossier = false;
    $this->boolInnovateurExiste = false;
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->dossierId);

    //recherche des innovateurs du dossier
    $this->arrInnovateur = Innovateur_dossier_mipTable::getInstance()->findByDossierMipId($this->dossierId);

    //verification qu'il y a des innovateurs
    if (count($this->arrInnovateur) != 0) {
      $this->boolInnovateurExiste = true;
    }
    $arrInnovateurs = array();
    foreach ($this->arrInnovateur as $objInnovateur) {
      if ($objInnovateur->getTypeInnovateurId() == Type_innovateurTable::PERSONNE_DE_REFERENCE) {
        $this->objInnovateurprincipal = UtilisateurTable::getInstance()->findOneById($objInnovateur->getUtilisateurId());
      } else {
        $arrInnovateurs[] = UtilisateurTable::getInstance()->findOneById($objInnovateur->getUtilisateurId());
      }

      //recherche si l'utilisateur est l'innovateur du dossier
      if ($objInnovateur->getUtilisateurId() == $this->getUser()->getUtilisateur()->getId()) {
        $this->boolEstInnovateurDuDossier = true;
      }
    }

    $this->arrInnovateursSecondaires = $arrInnovateurs;

    //recherche des évènements
    $this->arrEvenements = Evenement_mipTable::getInstance()->retrieveEvenementOrderByDate($this->dossierId);

    //recherche des remarques
    $this->arrRemarques = Remarque_mipTable::getInstance()->retreveRemarquesPourDossierMipOrdreDesc($this->dossierId);
  }

  public function executeVoirValorisationDossier_mip(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');

    
    $this->strId = $this->dossierId ;
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->dossierId);

    $this->objValorisation = ValorisationTable::getInstance()->findOneByDossierMipId($this->dossierId);

    $this->arrPrix = Prix_dossier_mipTable::getInstance()->retrievePrixByDossierId($this->dossierId);

    $this->boolPrixSelectionneExiste = false ;
    $this->boolPrixObtenuExiste = false ;
    $this->boolPrixExiste = false;
    
    foreach($this->arrPrix as $prix){
      if($prix->getEstSelectionne()) {
        $this->boolPrixSelectionneExiste = true ;
      }
      if($prix->getEstObtenu()){
        $this->boolPrixObtenuExiste = true ;
      }
    }
    if($this->boolPrixSelectionneExiste || $this->boolPrixObtenuExiste){
      $this->boolPrixExiste = true;
    }

    $this->arrDossierBpi = Dossier_mip_dossier_bpiTable::getInstance()->findByDossierMipId($this->dossierId);

  }
}

