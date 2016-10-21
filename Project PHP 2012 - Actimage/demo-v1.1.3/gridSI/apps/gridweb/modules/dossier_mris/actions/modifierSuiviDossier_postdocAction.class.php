<?php

/**
 * Modifier un élément de suivi de dossier postdoctoral
 *
 * @author Jihad
 */
class modifierSuiviDossier_postdocAction extends gridAction{
  public function  execute($objRequeteWeb) {

    if (!($objRequeteWeb->hasParameter('id') || $objRequeteWeb->hasParameter('dossier_id'))){
     $this->redirect("@non_autorise");
    }

    $objSuivi = Suivi_dossier_postdocTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objSuivi){
      $this->redirect('@non_autorise');
    }

    $this->objDossier = Dossier_postdocTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_id'));
    $this->strModelContenant = 'Dossier_postdoc';
    $this->idContenant = $objSuivi->getDossierPostdocId();

    
    $this->objForm = new Suivi_dossier_postdocForm($objSuivi);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='. $this->idContenant);
    }
    
  }

}
?>
