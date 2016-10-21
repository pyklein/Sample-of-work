<?php

/**
 * Suivi d'un dossier de these
 *
 * @author Jihad
 */
class listerSuivi_Dossier_thesesAction extends gridAction {

  public function execute($objRequeteWeb) {

    $this->objUser = $this->getUser();
    
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_these_id')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these_id');
      $this->strModelContenant = 'Dossier_these';
    } else {
      $this->redirect("@non_autorise");
    }

    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if ($this->objDossier) {
      $objRequeteDoctrine = Suivi_dossier_theseTable::getInstance()->getSuiviByDossierId($this->strIdContenant,  strtolower($this->strModelContenant));
      
      $this->processPager($objRequeteDoctrine, 'Suivi_dossier_these');
      
      $objSuivi = new Suivi_dossier_these();
      $objSuivi[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
      
      $this->objForm = new Suivi_dossier_theseForm($objSuivi);
      if ($objRequeteWeb->isMethod('post')) {
        $this->processForm('creer', 'listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='.$this->strIdContenant);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
