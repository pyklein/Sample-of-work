<?php

/**
 * Action pour l'évaluation des dossiers MRIS lorsqu'on vient de la liste des dossiers dans les commissions
 *
 * @author Actimage
 */
class evaluerCommissionPreselectionAction extends gridAction {

  public function execute($request) {

    //on vérifie les paramètres de l'URL
    if ($request->hasParameter('dossier_these_id')) {
      $this->strId = $request->getParameter('dossier_these_id');
      $this->strModelContenant = 'Dossier_these';
    } else if ($request->hasParameter('dossier_postdoc_id')) {
      $this->strId = $request->getParameter('dossier_postdoc_id');
      $this->strModelContenant = 'Dossier_postdoc';
    } else if ($request->hasParameter('dossier_ere_id')) {
      $this->strId = $request->getParameter('dossier_ere_id');
      $this->strModelContenant = 'Dossier_ere';
    } else {
      $this->redirect("@non_autorise");
    }

    //on récupère la commission ID
    if ($request->hasParameter('commission_id')) {
      $this->commissionId = $request->getParameter('commission_id');
      $evaluation_commission = array('commission_id' => $this->commissionId);
      $this->getUser()->setAttribute('evaluation_commission', $evaluation_commission);
    } else {
      //on cherche le dossier
      $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strId);
      if($this->objDossier){
      //Si on n'a pas de commission ID on cherche la commission de préselection
      $objCommission = CommissionTable::getInstance()->retrieveCommissionPreselection($this->objDossier->getCreatedAt(), strtolower($this->strModelContenant) );
      $this->commissionId = $objCommission->getId();
      $evaluation_commission = array('commission_id' => $this->commissionId);
      $this->getUser()->setAttribute('evaluation_commission', $evaluation_commission);
      }else{
        $this->redirect("@non_autorise");
      }
    }
    if(!$this->commissionId){
      $this->redirect("@non_autorise");
    }

    //on cherche la commission
    $objCommission = CommissionTable::getInstance()->findOneById($this->commissionId);

    if($objCommission)
      //on redirige en fonction du type de commission(présélection ou sélection)
      if($objCommission->getEstSelection()){
         $strRedirection = "evaluerSelectionDossier?" . strtolower($this->strModelContenant) . "_id=" . $this->strId . "&commission=true";
      }else{
        $strRedirection = "evaluerPreselectionDossier?" . strtolower($this->strModelContenant) . "_id=" . $this->strId . "&commission=true";
      }
    else{
      $this->redirect("@non_autorise");
    }
    $this->redirect($this->getModuleName() . "/" . $strRedirection);
  }

}
?>
