<?php

/**
 * Modifier un élément de suivi de dossier de thèse
 *
 * @author Jihad
 */
class modifierSuiviDossier_theseAction extends gridAction{
  public function  execute($objRequeteWeb) {

    if (!($objRequeteWeb->hasParameter('id') || $objRequeteWeb->hasParameter('dossier_id'))){
     $this->redirect("@non_autorise");
    }

    $objSuivi = Suivi_dossier_theseTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objSuivi){
      $this->redirect('@non_autorise');
    }

    $this->objDossier = Dossier_theseTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_id'));
    $this->strModelContenant = 'Dossier_these';
    $this->idContenant = $objSuivi->getDossierTheseId();

    
    $this->objForm = new Suivi_dossier_theseForm($objSuivi);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerSuivi_'.$this->strModelContenant.'s?'.strtolower($this->strModelContenant).'_id='. $this->idContenant);
    }
    
  }

}
?>
