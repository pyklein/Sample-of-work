<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Format");

class modifierDroitsAction extends gridAction {


  public function preExecute() {
    
  }

  public function execute($request) 
  {
    if ($request->hasParameter('dossier_bpi'))
    {
      $this->strId = $request->getParameter('dossier_bpi');
    } 
    else
    {
      $this->redirect("@non_authorise");
    }
    
    $objDossier = Dossier_bpiTable::getInstance()->findOneById($this->strId);
    if (!$objDossier || !$objDossier->getEstBrevetable()) {
      $this->redirect("@non_autorise");
    }

    $this->boolEstBrevetable = $objDossier->getEstBrevetable();
    
    $this->arrClassement = array();
    $this->objClassements = $objDossier['Classement_invention_inventeur'];

    if($this->objClassements != NULL)
    {
      foreach($this->objClassements as $objClassement)
      {
        $strAbreviation = $objClassement['Classement_final']->getAbreviation();
        if (!array_key_exists($strAbreviation, $this->arrClassement)){
          $this->arrClassement[$strAbreviation] = true;
        }
      }
    }

    $this->intNbInventeurExt = 0;
    $this->intNbInventeurExt = InventeurTable::getInstance()->retrieveInventeursExterieursByDossierId($objDossier->getId());
    
    $objDroit = new Attribution_droit();

    
    $this->objForm = new Dossier_bpi_Attribution_DroitForm($this->arrClassement,$objDossier);

    $this->boolContentieuxExist = Dossier_bpiTable::getInstance()->hasDossierContentieux($this->strId);
    
    if ($request->isMethod('post'))
    {
      $this->processForm('modifier', null, false);
    }
  }

}
