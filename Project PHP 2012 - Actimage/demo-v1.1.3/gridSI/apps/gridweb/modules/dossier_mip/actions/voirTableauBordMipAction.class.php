<?php

/**
 * Tableau de bord pour les dossiers MIP
 *
 * @author Jihad
 */
class voirTableauBordMipAction extends gridAction
{
  public function execute($request) 
  {
    $nbElementsParPage = sfConfig::get('app_nb_element_par_page_tableau_bord');
    $this->objUser = $this->getUser();

    //récupération des dossiers necessitant un controle
    $objRequeteControle = Dossier_mipTable::getInstance()->getDossierMIPAControler();

    //récuperation des nouveaux dossiers
    $this->arrDossiersNouveaux = Dossier_mipTable::getInstance()->getDossierMIP()->execute();

    //récupération des dossiers en cours pour lesquels l'utilisateur courant est pilote
    $objRequetePilote = Dossier_mipTable::getInstance()->getDossierMIPParPilote($this->objUser->getUtilisateur()->getId());

    //Initialisation pager
    $this->objPager1 = $this->processPager($objRequeteControle, 'Dossier_mip',true,1,$nbElementsParPage);
    $this->objPager2 = $this->processPager($objRequetePilote, 'Dossier_mip',true,2,$nbElementsParPage);
  }
}
