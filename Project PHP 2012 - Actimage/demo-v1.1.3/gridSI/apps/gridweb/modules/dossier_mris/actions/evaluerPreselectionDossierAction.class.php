<?php

/**
 * Evaluation de préselection des dossiers MRIS
 *
 * @author Actimage
 */
class evaluerPreselectionDossierAction extends gridAction {

  public function execute($request) {

     $this->boolListeCommission = false;
     $this->boolListeDossier = false;

    //on vérifie les paramètres de l'URL
    if ($request->hasParameter('dossier_these_id')) {
      $this->strId = $request->getParameter('dossier_these_id');
      $this->strModelContenant = 'Dossier_these';

    } else if($request->hasParameter('dossier_postdoc_id')){
      $this->strId = $request->getParameter('dossier_postdoc_id');
      $this->strModelContenant = 'Dossier_postdoc';

    } else if($request->hasParameter('dossier_ere_id')){
      $this->strId = $request->getParameter('dossier_ere_id');
      $this->strModelContenant = 'Dossier_ere';

    } else {
      $this->redirect("@non_autorise");
    }

    if($request->hasParameter('commission')){
      $this->commissionId =  $this->getUser()->getAttribute('evaluation_commission');
      $this->commissionId = $this->commissionId['commission_id'];
      $this->boolListeCommission = true;
    }else if($request->hasParameter('dossier')){
      $this->commissionId =  $this->getUser()->getAttribute('evaluation_commission');
      $this->commissionId = $this->commissionId['commission_id'];
      $this->boolListeDossier = true;
    }

    
    // on verifie que le dossier existe sinon on redirige
    if (($this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strId))) {

      $this->arrNotes = Doctrine_Core::getTable('Note')->findAll();

      //on regarde s'il y a déjà une evaluation globale pour le dossier
      $arrEvaluationsCheck = Doctrine_Core::getTable('Evaluation')->getEvaluationPreselectionByTypeDossierAndEstGlobal($this->strModelContenant,$this->objDossier->getId());
      //on inclut l'objet evaluation dans la bonne variable 
      foreach($arrEvaluationsCheck as $objEval){
        $objEvaluation = $objEval ;
      }
      //si il n'y a pas d'objEvaluation, on va en créer un
      if($arrEvaluationsCheck->count() != 1){
        $objEvaluation = new Evaluation();
      }

      //on set l'objet Evaluation
      $objEvaluation->setEstGlobale(true);
      $objEvaluation->setEstPreselection(true);
      if($this->strModelContenant == 'Dossier_these') $objEvaluation->setDossierTheseId($this->objDossier->getId());
      if($this->strModelContenant == 'Dossier_postdoc') $objEvaluation->setDossierPostdocId($this->objDossier->getId());
      if($this->strModelContenant == 'Dossier_ere') $objEvaluation->setDossierEreId($this->objDossier->getId());
      
      $this->objForm = new Evaluation_Preselection_Dossier_MrisForm($this->getUser()->getUtilisateur()->getId(),true,$this->objDossier, $this->arrNotes, $objEvaluation);

      if ($request->isMethod('post')) {
        if($request->hasParameter('enregistrer')){
          if($request->hasParameter('dossier')) $this->processForm('modifier', null, false);
        }
        if($request->hasParameter('enregistrer_retour')){
          if($request->hasParameter('commission')) $this->processForm('modifier', "listerDossiersCommission?id=".$this->commissionId."&proposition=true", true);
          if($request->hasParameter('dossier')) $this->processForm('modifier', "lister".$this->strModelContenant."s", true);

        }else if($request->hasParameter('enregistrer_suivant')){

          //si on est dans le cas de la commission
          if($request->hasParameter('commission'))
          {
            //on cherche le dossier suivant
            $objDossierSuivant = EvaluationTable::getInstance()->retrieveDossierSuivantListeCommission($this->objDossier->getId(), $this->objDossier->getDomaineScientifiqueId(), $this->objDossier->getTable()->getTableName(),  $this->commissionId);
            //on vérifie s'il y a un dossier suivant sinon on redirige vers le listing
            if($objDossierSuivant == null){
              $this->processForm('modifier', "listerDossiersCommission?id=".$this->commissionId."&proposition=true", true);
            }else {
              $this->processForm('modifier', "evaluerPreselectionDossier?".strtolower($this->strModelContenant)."_id=".$objDossierSuivant->getId()."&commission=true", true);
            }
          //si on est dans le cas du dossier
          }else if($request->hasParameter('dossier')){
            //on cherche le dossier suivant
            $objDossierSuivant = EvaluationTable::getInstance()->retrieveDossierSuivantListeCommission($this->objDossier->getId(), $this->objDossier->getDomaineScientifiqueId(), $this->objDossier->getTable()->getTableName(),  $this->commissionId);
            //on vérifie s'il y a un dossier suivant sinon on redirige vers le listing
            if($objDossierSuivant == null){
              $this->processForm('modifier', "lister".$this->strModelContenant."s", true);
            }else{
              $this->processForm('modifier', "evaluerPreselectionDossier?".strtolower($this->strModelContenant)."_id=".$objDossierSuivant->getId()."&dossier=true", true);
            }
          }
          
        }
      }
      
    } else {
      $this->redirect("@non_autorise");
    }
  }

}
?>
