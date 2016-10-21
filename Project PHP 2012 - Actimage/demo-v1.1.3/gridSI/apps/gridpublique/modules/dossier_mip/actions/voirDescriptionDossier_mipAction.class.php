<?php

/**
 * Action pour la vue de la description du dossier
 *
 * @author Actimage
 */
class voirDescriptionDossier_mipAction extends gridAction {

  public function preExecute() {
    
  }

  public function execute($request) 
  {
    if(!$request->hasParameter('id'))
    {
      $this->redirect("dossier_mip/listerDossier_mip_publiques");
    }
    
    $this->strId = $request->getParameter('id');
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->strId);

    //verifier que le dossier existe
    if (!$this->objDossierMip 
            || !$this->objDossierMip->getEstActif()
            || !$this->objDossierMip->getEstPublie()
            || in_array($this->objDossierMip->getStatutProjetMipId(), array(Statut_projet_mipTable::PRE_PROJET_EN_COURS, Statut_projet_mipTable::PRE_PROJET_ABANDON)))
    {
      $this->redirect('dossier_mip/listerDossier_mip_publiques');
    }

    //recherche des innovateurs du dossier
    $this->arrInnovateur = Innovateur_dossier_mipTable::getInstance()->findByDossierMipId($this->strId);
    $this->boolInnovateurExiste = false;
    $this->objInnovateurprincipal = "";

    //verification qu'il y a des innovateurs
    if (count($this->arrInnovateur) != 0) {
      $this->boolInnovateurExiste = true;
    }
    $arrInnovateurs = array();
    foreach ($this->arrInnovateur as $objInnovateur)
    {
      if ($objInnovateur->getTypeInnovateurId() == Type_innovateurTable::PERSONNE_DE_REFERENCE)
      {
        $this->objInnovateurprincipal = UtilisateurTable::getInstance()->findOneById($objInnovateur->getUtilisateurId());
      } 
      else
      {
        $arrInnovateurs[] = UtilisateurTable::getInstance()->findOneById($objInnovateur->getUtilisateurId());
      }

    }

      $this->arrInnovateursSecondaires = $arrInnovateurs;
    }
  

}
?>
