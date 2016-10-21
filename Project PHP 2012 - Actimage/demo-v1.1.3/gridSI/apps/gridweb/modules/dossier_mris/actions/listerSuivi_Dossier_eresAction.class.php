<?php

/**
 * Suivi d'un dossier de stage ERE
 *
 * @author Jihad
 */
class listerSuivi_Dossier_eresAction extends gridAction {

  public function execute($objRequeteWeb) {

    $this->objUser = $this->getUser();
    
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_ere_id')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere_id');
      $this->strModelContenant = 'Dossier_ere';
    } else {
      $this->redirect("@non_autorise");
    }

    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if ($this->objDossier) {
      $objRequeteDoctrine = Suivi_dossier_ereTable::getInstance()->getSuiviByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));
      
      $this->processPager($objRequeteDoctrine, 'Suivi_dossier_ere');
      
      $objSuivi = new Suivi_dossier_ere();
      $objSuivi[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
      
      $this->objForm = new Suivi_dossier_ereForm($objSuivi);
      if ($objRequeteWeb->isMethod('post')) {
        $this->processForm('creer', 'listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='.$this->strIdContenant);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
