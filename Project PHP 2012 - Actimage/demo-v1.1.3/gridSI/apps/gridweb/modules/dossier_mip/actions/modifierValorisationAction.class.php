<?php
/**
 * Description of modifierValorisation_dossier_mipAction
 *
 * @author William
 */
class modifierValorisationAction extends gridAction{
    public function  preExecute() {
    parent::preExecute();
  }

  public function  execute($request) {
    $this->strDossierId = $request->getParameter('dossier_mip');
    $objDossier = Dossier_mipTable::getInstance()->findOneById($this->strDossierId);
    if (!$objDossier || !$objDossier->getEstActif()){
      $this->redirect("@non_autorise");
    }
    $this->objForm = new Dossier_mipValorisationForm($objDossier);
    $this->arrDossiersBPI =  Dossier_bpiTable::getInstance()->retrieveDossierBPIConcernes('', $this->strDossierId)->execute();
    $this->arrPrix = Prix_dossier_mipTable::getInstance()->retrievePrixByDossierId($this->strDossierId);

    if ($request->isMethod('post')){
      //sauvegarde infos Prix
      foreach ($this->arrPrix as $prix){
        $prix->setEstObtenu(  $request->getParameter('obtenu_'.$prix->getPrix()->getId(),null) != null ? 1 : 0);
        $prix->setEstSelectionne(  $request->getParameter('selectionne_'.$prix->getPrix()->getId(),null) != null ? 1 : 0);
        $prix->setAnnee($request->getParameter('annee_'.$prix->getPrix()->getId()));
        $prix->save();
      }

      //traitement forme valorisation
      $this->processForm('modifier',null,false);
    }
    ;
  }
}
?>
