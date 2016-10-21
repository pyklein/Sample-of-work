<?php

/**
 * Modifier un élément de suivi de dossier de stage ERE
 *
 * @author Jihad
 */
class modifierSuiviDossier_ereAction extends gridAction{
  public function  execute($objRequeteWeb) {

    if (!($objRequeteWeb->hasParameter('id') || $objRequeteWeb->hasParameter('dossier_id'))){
     $this->redirect("@non_autorise");
    }

    $objSuivi = Suivi_dossier_ereTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objSuivi){
      $this->redirect('@non_autorise');
    }

    $this->objDossier = Dossier_ereTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_id'));
    $this->strModelContenant = 'Dossier_ere';
    $this->idContenant = $objSuivi->getDossierEreId();

    
    $this->objForm = new Suivi_dossier_ereForm($objSuivi);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='. $this->idContenant);
    }
    
  }

}
?>
