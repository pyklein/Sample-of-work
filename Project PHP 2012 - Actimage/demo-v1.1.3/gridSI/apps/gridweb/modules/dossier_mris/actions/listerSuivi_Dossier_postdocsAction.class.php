<?php

/**
 * Suivi d'un dossier de stage postdoctoral
 *
 * @author Jihad
 */
class listerSuivi_Dossier_postdocsAction extends gridAction {

  public function execute($objRequeteWeb) {

    $this->objUser = $this->getUser();
    
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_postdoc_id')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc_id');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }

    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if ($this->objDossier) {
      $objRequeteDoctrine = Suivi_dossier_postdocTable::getInstance()->getSuiviByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));
      
      $this->processPager($objRequeteDoctrine, 'Suivi_dossier_postdoc');
      
      $objSuivi = new Suivi_dossier_postdoc();
      $objSuivi[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
      
      $this->objForm = new Suivi_dossier_postdocForm($objSuivi);
      if ($objRequeteWeb->isMethod('post')) {
        $this->processForm('creer', 'listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='.$this->strIdContenant);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
