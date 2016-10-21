<?php

/**
 * Description of modifierEvenement_mrisAction
 *
 * @author Jihad
 */
class modifierEvenement_mrisAction extends gridAction{
  public function  execute($objRequeteWeb) {

    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }

    $objEvenement = Evenement_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objEvenement){
      $this->redirect('@non_autorise');
    }

    if($objEvenement->getDossierPostdocId()!=NULL)
    {
      $this->strContenant = 'dossier_postdoc';
      $this->idContenant = $objEvenement->getDossierPostdocId();
    }
    else if($objEvenement->getDossierTheseId()!=NULL)
    {
      $this->strContenant = 'dossier_these';
      $this->idContenant = $objEvenement->getDossierTheseId();
    }
    else if($objEvenement->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'dossier_ere';
      $this->idContenant = $objEvenement->getDossierEreId();
    }
    else
    {
      $this->redirect('@non_autorise');
    }
    $this->objDossier = Doctrine_Core::getTable(ucfirst($this->strContenant))->findOneById($objRequeteWeb->getParameter('dossier_id'));

    $this->objForm = new Evenement_mrisForm($this->strContenant,$objEvenement);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerEvenement_mris?'.$this->strContenant.'='. $this->idContenant);
    }
    
  }

}
?>
