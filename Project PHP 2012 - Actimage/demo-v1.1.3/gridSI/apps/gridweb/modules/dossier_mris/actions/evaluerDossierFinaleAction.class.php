<?php

/**
 * Evaluation finale d'un dossier MRIS
 *
 * @author Actimage
 */
class evaluerDossierFinaleAction extends gridAction {

  public function execute($request) {

    //initialisation des variables
    $this->boolListeCommission = false;
    $this->boolListeDossier = false;
    $arrNotesInvitation = array();

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

     $this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strId);

    // on verifie que le dossier existe sinon on redirige
    if ($this->objDossier) {
      $this->arrCommission = $this->getUser()->getAttribute('evaluation_commission');
      if ($request->hasParameter('commission'))
      {
        if($this->arrCommission)
        {
          $this->commissionId = $this->arrCommission['commission_id'];
          $this->boolListeCommission = true;

          //on cherche la commission
          $objCommission = CommissionTable::getInstance()->findOneById($this->commissionId);

            //si ce n'est pas une commission de sélection on recherche la commission de sélection la plus proche du dossier
            if(!$objCommission->getEstSelection()){
              //recherche la commission de sélection
              $objCommission = CommissionTable::getInstance()->retrieveCommissionSelection($this->objDossier->getCreatedAt(), strtolower($this->strModelContenant) );
              if($objCommission){
                 $this->commissionId = $objCommission->getId();
              }else{
                $this->getUser()->setFlash("erreur", libelle("msg_libelle_aucune_commission_selection"));
              }

            }
        }

      }
      else if ($request->hasParameter('dossier'))
      {
        //on cherche la commission de selection
        $objCommission = CommissionTable::getInstance()->retrieveCommissionSelection($this->objDossier->getCreatedAt(), strtolower($this->strModelContenant) );

        //on vérifie que la commission existe sinon on redirige
        if($objCommission)
        {
          $this->commissionId = $objCommission->getId();
        }  
        else
        {
          $this->getUser()->setFlash("warning", libelle("msg_libelle_aucune_commission_selection"));
        }
        
        $this->boolListeDossier = true;
      }

      if($this->commissionId != NULL)
      {
        //on recherche la note globale de la présélection
        $this->notePreselection = EvaluationTable::getInstance()->retrieveNotePreselection(strtolower($this->strModelContenant),$this->objDossier->getId()) ;

        //on recherche les services et laboratoires qui ont une invitation pour cette commission
        $this->arrInvitations = InvitationTable::getInstance()->findByCommissionId($this->commissionId);

        foreach($this->arrInvitations as $invitation){
          //recherche des notes globales pour les services et laboratoires
          $arrNotesInvitation[$invitation->getId()] = EvaluationTable::getInstance()->retrieveNoteSelection($invitation->getId(), strtolower($this->strModelContenant), $this->objDossier->getId());
        }

        $this->arrNotesInvitation = $arrNotesInvitation;
      }
      else
      {
         $this->getUser()->setFlash("warning", libelle("msg_libelle_aucune_commission_selection"));
      }
    
        $queryEvaluationFinale = EvaluationTable::getInstance()->retrieveQueryEvaluationFinaleDossier($this->strId, strtolower($this->strModelContenant));
        $objEvaluationFinale = EvaluationTable::getInstance()->retrieveEvaluationFinaleDossier($this->strId, strtolower($this->strModelContenant));

        //on vérifie que l'objet existe sinon on en crée un nouveau
        if($queryEvaluationFinale->count() == 0){
          $objEvaluationFinale = new Evaluation();
          $objEvaluationFinale->setEstFinale(true);
          if($this->strModelContenant == 'Dossier_these') $objEvaluationFinale->setDossierTheseId($this->objDossier->getId());
          if($this->strModelContenant == 'Dossier_postdoc') $objEvaluationFinale->setDossierPostdocId($this->objDossier->getId());
          if($this->strModelContenant == 'Dossier_ere') $objEvaluationFinale->setDossierEreId($this->objDossier->getId());
        }


        $this->objForm = new Evaluation_Finale_Dossier_MrisForm($objEvaluationFinale);


        //POST du formulaire
        if ($request->isMethod('post')) {
          //si on est dans le cas de la commission
          if($request->hasParameter('commission'))
          {
            $this->processForm('modifier', "listerDossiersCommission?id=".$this->commissionId."&proposition=true", true);
          }
          //si on est dans le cas de la commission
          if($request->hasParameter('dossier'))
          {
            $this->processForm('modifier', null, false);
          }
        }
      }
      
     else
     {
       $this->redirect("@non_autorise");
     }
  }
}
?>
