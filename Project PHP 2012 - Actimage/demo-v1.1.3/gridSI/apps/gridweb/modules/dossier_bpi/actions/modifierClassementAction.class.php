<?php

/**
 * Description of modifierClassementAction
 *
 * @author William
 */
class modifierClassementAction extends gridAction {

  public function execute($request) {
    $this->strId = $request->getParameter('dossier_bpi');
    $objDossier = Dossier_bpiTable::getInstance()->findOneById($this->strId);
    if (!$objDossier){
      $this->redirect("@non_autorise");
    }
    if (!$objDossier->getEstActif()){
      $this->redirect("@non_autorise");
    }
   
    $this->arrInventeurs = InventeurTable::getInstance()->retrieveInventeursConcernes('', $objDossier->getId())->orderBy('id')->execute();
    $this->objForm = new Dossier_bpiClassementForm($this->arrInventeurs,$objDossier);

    $this->arrClassements = $objDossier['Classement_invention_inventeur'];

    $this->boolContentieuxExist = Dossier_bpiTable::getInstance()->hasDossierContentieux($this->strId);

    $this->objDocumentsJoints = Documents_bpiTable::getInstance()->retrieveDocumentsByDossier($this->strId, true);
    $this->objDocumentsReferences = Documents_bpiTable::getInstance()->retrieveDocumentsByDossier($this->strId, false);

    if ($request->isMethod('post')){
      $this->processForm('modifier',$this->getActionName().'?dossier_bpi='.$this->strId);
    }

  }
}

?>
