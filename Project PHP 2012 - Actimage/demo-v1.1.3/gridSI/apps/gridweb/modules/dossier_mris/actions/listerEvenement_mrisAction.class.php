<?php

/**
 * Lister les evenements sur les dossiers mris
 *
 * @author Jihad
 */
class listerEvenement_mrisAction extends gridAction {

  public function execute($objRequeteWeb) {

    $this->objUser = $this->getUser();
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_these')) {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these');
      $this->strModelContenant = 'Dossier_these';
    } elseif ($objRequeteWeb->hasParameter('dossier_ere')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere');
      $this->strModelContenant = 'Dossier_ere';
    } elseif ($objRequeteWeb->hasParameter('dossier_postdoc')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }

    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if ($this->objDossier) {
      $objRequeteDoctrine = Evenement_mrisTable::getInstance()->getEvenementsByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));
      
      $this->processPager($objRequeteDoctrine, 'Evenement_mris');
      
      $objEvenement = new Evenement_mris();
      $objEvenement[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
      
      $this->objForm = new Evenement_mrisForm($this->strModelContenant,$objEvenement);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('evenement_mris')) {
        $this->processForm('creer', 'listerEvenement_mris?'.strtolower($this->strModelContenant).'='.$this->strIdContenant);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
