<?php

/**
 * Evaluation de sélection des dossiers MRIS
 *
 * @author Actimage
 */
class evaluerSelectionDossierAction extends gridAction {

  public function execute($request) {

    //initialisation des variables
    $objCommission = NULL;
    $this->boolListeCommission = false;
    $this->boolListeDossier = false;
    $this->boolInvitationExiste = false;

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

      if ($request->hasParameter('commission')) {

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

      
      else if ($request->hasParameter('dossier')) {
        //on cherche la commission de selection
        $objCommission = CommissionTable::getInstance()->retrieveCommissionSelection($this->objDossier->getCreatedAt(), strtolower($this->strModelContenant) );
        //on vérifie si la commission existe
        if($objCommission){
          $this->commissionId = $objCommission->getId();
          
        }else
        {
          $this->getUser()->setFlash("warning", libelle("msg_libelle_aucune_commission_selection"));
        }
        $this->boolListeDossier = true;
      }
      

      if($objCommission != NULL)
      {
        $this->arrNotes = Doctrine_Core::getTable('Note')->findByEstSelection(true);

        //on recherche les services et laboratoires qui ont une invitation pour cette commission
        $this->arrInvitations = InvitationTable::getInstance()->findByCommissionId($this->commissionId);

       //si ya des invitations, on affiche les formulaires
       if($this->arrInvitations->count() != 0){

          $this->boolInvitationExiste = true;

          if($this->strModelContenant == 'Dossier_these')    $this->objForm = new Evaluation_Selection_Dossier_These_Formulaire_PrincipaleForm($this->strModelContenant,$this->arrNotes, $this->objDossier, $this->getUser()->getUtilisateur()->getId(), $this->arrInvitations, $this->objDossier) ;
          if($this->strModelContenant == 'Dossier_postdoc')  $this->objForm = new Evaluation_Selection_Dossier_Postdoc_Formulaire_PrincipaleForm($this->strModelContenant,$this->arrNotes, $this->objDossier, $this->getUser()->getUtilisateur()->getId(), $this->arrInvitations, $this->objDossier) ;
          if($this->strModelContenant == 'Dossier_ere')      $this->objForm = new Evaluation_Selection_Dossier_Ere_Formulaire_PrincipaleForm($this->strModelContenant,$this->arrNotes, $this->objDossier, $this->getUser()->getUtilisateur()->getId(), $this->arrInvitations, $this->objDossier) ;
       }

        //POST du formulaire
        if ($request->isMethod('post')) {
          if($request->hasParameter('enregistrer')){
            if($request->hasParameter('dossier')) $this->processForm('modifier', null, false);
          }

           //CAS du bouton revenir à la liste des dossiers
          if($request->hasParameter('enregistrer_retour')){
             if($request->hasParameter('commission')) $this->processForm('modifier', "listerDossiersCommission?id=".$this->commissionId."&proposition=true", true);
             if($request->hasParameter('dossier')) $this->processForm('modifier', "lister".$this->strModelContenant."s", true);

          }//CAS du bouton aller au dossier suivant
          else if($request->hasParameter('enregistrer_suivant')){

             //si on est dans le cas de la commission
            if($request->hasParameter('commission'))
            {
              //on cherche le dossier suivant
              $objDossierSuivant = EvaluationTable::getInstance()->retrieveDossierSuivantListeCommission($this->objDossier->getId(), $this->objDossier->getDomaineScientifiqueId(), $this->objDossier->getTable()->getTableName(),  $this->commissionId);
              //on vérifie s'il y a un dossier suivant sinon on redirige vers le listing
              if($objDossierSuivant == null){
                $this->processForm('modifier', "listerDossiersCommission?id=".$this->commissionId."&proposition=true", true);
              }else {
                $this->processForm('modifier', "evaluerSelectionDossier?".strtolower($this->strModelContenant)."_id=".$objDossierSuivant->getId()."&commission=true", true);
              }
            }
             //si on est dans le cas de la liste de dossier
            if($request->hasParameter('dossier'))
            {
              //on cherche le dossier suivant
              $objDossierSuivant = EvaluationTable::getInstance()->retrieveDossierSuivantListeCommission($this->objDossier->getId(), $this->objDossier->getDomaineScientifiqueId(), $this->objDossier->getTable()->getTableName(),  $this->commissionId);
              //on vérifie s'il y a un dossier suivant sinon on redirige vers le listing
              if($objDossierSuivant == null){
                $this->processForm('modifier', "lister".$this->strModelContenant."s", true);
              }else {
                $this->processForm('modifier', "evaluerSelectionDossier?".strtolower($this->strModelContenant)."_id=".$objDossierSuivant->getId()."&dossier=true", true);
              }

            }

          }

        }
      }
      else
      {
        $this->getUser()->setFlash("warning", libelle("msg_libelle_aucune_commission_selection"));
      }
      
    }
//  }
    else
    {
      $this->redirect("@non_autorise");
    }
  }

}
?>
