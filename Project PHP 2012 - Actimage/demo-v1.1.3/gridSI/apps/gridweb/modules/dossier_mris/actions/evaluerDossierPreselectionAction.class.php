<?php

/**
 * action pour l'évaluation des dossiers MRIS lorsqu'on vient de
 * la liste des dossiers (thèse, postdoc, ere) ou de la liste "Autres actions"
 *
 * @author Actimage
 */
class evaluerDossierPreselectionAction extends gridAction {

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

    //on cherche le dossier
    $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strId);
    if ($this->objDossier) {
      //Si on n'a pas de commission ID on cherche la commission de préselection
      $objCommission = CommissionTable::getInstance()->retrieveCommissionPreselection($this->objDossier->getCreatedAt(), strtolower($this->strModelContenant));
      //on vérifie que la commission existe
      if($objCommission->getId() != null)
      {
        $this->commissionId = $objCommission->getId();
        $evaluation_commission = array('commission_id' => $this->commissionId);
        $this->getUser()->setAttribute('evaluation_commission', $evaluation_commission);
      }
      else
      {
//         $this->redirect("@non_autorise");
         $this->getUser()->setFlash('warning', libelle('msg_libelle_aucune_commission_preselection'));
         $this->redirect('dossier_mris/lister'.$this->strModelContenant.'s');
      }
    } else {
      $this->redirect("@non_autorise");
    }

    //redirection
    $strRedirection = "evaluerPreselectionDossier?" . strtolower($this->strModelContenant) . "_id=" . $this->strId . "&dossier=true";

    $this->redirect($this->getModuleName() . "/" . $strRedirection);
  }

}
?>
