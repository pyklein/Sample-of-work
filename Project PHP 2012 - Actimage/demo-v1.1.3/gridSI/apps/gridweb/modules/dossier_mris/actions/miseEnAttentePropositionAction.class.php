<?php

/**
 * Mise en attente d'un dossier
 *
 * @author Jihad 
 */
class miseEnAttentePropositionAction extends gridAction {

  public function execute($objRequeteWeb) {
      
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
    if (!$this->objDossier)
    {
      $this->redirect('@non_autorise');
    }

    $form = $this->strModelContenant."_classementForm";
    $this->objForm = new $form($this->objDossier);

    $strStatutDossierTable = "Statut_".strtolower($this->strModelContenant)."Table";

    if ($objRequeteWeb->isMethod('post'))
    {
      $this->objForm->bind($objRequeteWeb->getPostParameter($this->objForm->getName()), array());
      $this->objDossier['statut_'.strtolower($this->strModelContenant). '_id'] = $strStatutDossierTable::MIS_EN_ATTENTE;
      $this->objDossier['mis_en_attente_le'] = date("Y-m-d H:i:s");

      if($this->objForm->isValid())
      {
        $this->objForm->save();
        $this->objDossier->save();
        $this->redirect('dossier_mris/validerDossier?'.strtolower($this->strModelContenant).'='.$this->strIdContenant);
      }
    }
  }
}

