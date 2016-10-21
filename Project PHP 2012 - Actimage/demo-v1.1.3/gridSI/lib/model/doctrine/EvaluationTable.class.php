<?php

/**
 * EvaluationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EvaluationTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return object EvaluationTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Evaluation');
  }

  /**
   * Retourne une évaluation de préselection avec 'est_global' = true, 'est_preselection' =true et le type de dossier
   *
   * @param String $typeDossier le type de dossier (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Actimage
   * @return object Evaluation
   */
  public function getEvaluationPreselectionByTypeDossierAndEstGlobal($typeDossier, $dossier_id) {

    if ($typeDossier == 'Dossier_these') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 1')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_these_id = ?', $dossier_id);
    } else if ($typeDossier == 'Dossier_postdoc') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 1')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id);
    } else if ($typeDossier == 'Dossier_ere') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 1')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_ere_id = ?', $dossier_id);
    }

    return $doctrineQuery->execute();
  }

  /**
   * Retourne une évaluation de préselection en fonction d'une noteId et d'un dossier
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $noteID Id de la note
   * @author Actimage
   * @return object Evaluation
   */
  public function getEvaluationPreselectionByNoteIdAndDossierId($noteID, $dossier_id, $typeDossier) {

    if ($typeDossier == 'dossier_these') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 0')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('note_id = ?', $noteID)
                      ->andWhere('dossier_these_id = ?', $dossier_id);
    } else if ($typeDossier == 'dossier_postdoc') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 0')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('note_id = ?', $noteID)
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id);
    } else if ($typeDossier == 'dossier_ere') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 0')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('note_id = ?', $noteID)
                      ->andWhere('dossier_ere_id = ?', $dossier_id);
    }

    return $doctrineQuery->execute();
  }

  /**
   * Retourne le prochain dossier (par rapport à un dossier courant) du même type (thèse, ere, postdoc)
   * en fonction d'une commission et d'un domaine scientifique
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossierCourantId Id du dossier courant
   * @param Integer $domaineScId Id du domaine scientifique
   * @param Integer $commissionId id de la commission
   * @author Actimage
   * @return Array Dossier
   */
  public function retrieveDossierSuivantListeCommission($dossierCourantId, $domaineScId, $typeDossier, $commissionId) {


    if ($typeDossier == 'dossier_these'){
      $modelName = 'Dossier_these';
      $statutPropositionDossier = Statut_dossier_theseTable::PROPOSITION;
    }
    if ($typeDossier == 'dossier_postdoc'){
      $modelName = 'Dossier_postdoc';
      $statutPropositionDossier = Statut_dossier_postdocTable::PROPOSITION;
    }
    if ($typeDossier == 'dossier_ere'){
      $modelName = 'Dossier_ere';
      $statutPropositionDossier = Statut_dossier_ereTable::PROPOSITION;
    }

    $boolTrouveDossier = false;
    $objDossierSuivant = null;

    //on cherche la commission
    $objCommission = CommissionTable::getInstance()->findOneById($commissionId);
    $anneeCommission = $objCommission->getDateTimeObject('date_debut')->format('Y');
    $dateCommission = $objCommission->getDateTimeObject('date_debut')->format('Y-m-d');

    $objRequeteDoctrine = Doctrine_Core::getTable($modelName)->createQuery('d')
                    ->where('d.created_at >= ?', $anneeCommission -1 . '-01-01 00:00:00')
                    ->andWhere('d.created_at <= ?', $dateCommission  . ' 00:00:00')
                    ->andWhere('d.est_actif = 1')
                    ->andWhere('d.domaine_scientifique_id = ?', $domaineScId)
                    ->andWhere('d.statut_' . $typeDossier . '_id = ?', $statutPropositionDossier)
                    ->orderBy('d.created_at DESC')
                    ->execute();

    foreach ($objRequeteDoctrine as $dossier) {
      //D'abord on check si dans la boucle précédente on a trouvé le dossier courant
      //puis on retourne le dossier qui est le dossier suivant
      if ($boolTrouveDossier) {
        return $dossier;
        $boolTrouveDossier = false;
      }

      //on check si les ID des 2 dossiers correspondent
      if ($dossier->getId() == $dossierCourantId) {
        $boolTrouveDossier = true;
      }
    }
  }

  /**
   * Retourne le prochain dossier (par rapport à un dossier courant) du même type (thèse, ere, postdoc)
   *
   * @param String $typeDossier le type de dossier (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @param Integer $dossierCourantId Id du dossier courant
   * @author Actimage
   * @return Array Dossier
   */
  public function retrieveDossierSuivantListeDossier($dossierCourantId, $typeDossier) {

    if($typeDossier == "Dossier_these"){
      $strProposition = Statut_dossier_theseTable::PROPOSITION ;
    }else if ($typeDossier == "Dossier_postdoc") {
      $strProposition = Statut_dossier_postdocTable::PROPOSITION;
    }elseif ($typeDossier == "Dossier_ere") {
      $strProposition = Statut_dossier_ereTable::PROPOSITION;
    }

    $objRequeteDoctrine = Doctrine_Core::getTable($typeDossier)->createQuery('d')
                    ->where('d.statut_' . strtolower($typeDossier) . '_id = ?', $strProposition)
                    ->orderBy('d.created_at DESC')
                    ->execute();

    $boolTrouveDossier = false;

    foreach ($objRequeteDoctrine as $dossier) {
      //D'abord on check si dans la boucle précédente on a trouvé le dossier courant
      //puis on retourne le dossier qui est le dossier suivant
      if ($boolTrouveDossier) {
        return $dossier;
        $boolTrouveDossier = false;
      }

      //on check si les ID des 2 dossiers correspondent
      if ($dossier->getId() == $dossierCourantId) {
        $boolTrouveDossier = true;
      }
    }
  }

   /**
   * Retourne la quéry pour la fonction getEvaluationSelectionByTypeDossierAndEstGlobal()
   *
   * @param String $typeDossier le type de dossier (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $invitation_id Id de l'invitation
   * @author Actimage
   * @return doctrine_query
   */
  public function getQueryEvaluationSelectionByTypeDossierAndEstGlobal($typeDossier, $dossier_id, $invitation_id) {

    $doctrineQuery = $this->createQuery('e')
                    ->where('est_globale = 1')
                    ->andWhere('est_preselection = 0')
                    ->andWhere('invitation_id = ?', $invitation_id)
                    ->andWhere(strtolower($typeDossier) . '_id = ?', $dossier_id);

    return $doctrineQuery;
  }
  /**
   * Retourne une évaluation de selection avec 'est_global' = true, 'est_preselection' =false , le type de dossier et l'invitation
   *
   * @param String $typeDossier le type de dossier (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $invitation_id Id de l'invitation
   * @author Actimage
   * @return object Evaluation
   */
  public function getEvaluationSelectionByTypeDossierAndEstGlobal($typeDossier, $dossier_id, $invitation_id) {

    $doctrineQuery = $this->getQueryEvaluationSelectionByTypeDossierAndEstGlobal($typeDossier, $dossier_id, $invitation_id);

    return $doctrineQuery->execute();
  }

  /**
   * Retourne une évaluation de sélection en fonction d'une noteId, d'un dossier et d'une invitation
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $note_id Id de la note
   * @param Integer $invitation_id Id de l'invitation
   * @author Actimage
   * @return object Evaluation
   */
  public function getEvaluationSelectionByNoteIdAndDossierId($note_id, $dossier_id, $typeDossier, $invitation_id) {

    return $this->getQueryEvaluationSelectionByNoteIdAndDossierId($note_id, $dossier_id, $typeDossier, $invitation_id)->execute();
    
  }

  /**
   * Retourne une query pour la fonction getEvaluationSelectionByNoteIdAndDossierId()
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $note_id Id de la note
   * @param Integer $invitation_id Id de l'invitation
   * @author Actimage
   * @return Doctrine Query
   */
  public function getQueryEvaluationSelectionByNoteIdAndDossierId($note_id, $dossier_id, $typeDossier, $invitation_id) {

    $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 0')
                      ->andWhere('est_preselection = 0')
                      ->andWhere('invitation_id = ?',$invitation_id )
                      ->andWhere('note_id = ?', $note_id)
                      ->andWhere('id IS NOT NULL')
                      ->andWhere($typeDossier.'_id = ?', $dossier_id);

    return $doctrineQuery;

  }


  /**
   * Retrouve la note globale de présélection d'un dossier
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Actimage
   * @return object Evaluation
   */
  public function retrieveNotePreselection($typeDossier, $dossier_id){

     $doctrineQuery = $this->createQuery('e')
                      ->where('est_globale = 1')
                      ->andWhere('est_preselection = 1')
                      ->andWhere('est_actif = 1')
                      ->andWhere($typeDossier.'_id = ?', $dossier_id);
     
     $arrEvaluation =  $doctrineQuery->execute();

     $objEvaluation = $arrEvaluation[0] ;

      if($objEvaluation->getValeurNoteId() != null){
      return Valeur_noteTable::getInstance()->findOneById($objEvaluation->getValeurNoteId())->getIntitule();
    }else{
      return null;
    }
    
    
  }

   /**
   * Retrouve la note globale de l'invitation (Service ou laboratoire)
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @param Integer $invitation_id Id de l'invitation
   * @author Actimage
   * @return String Valeur_note->getIntitule()
   */
  public function retrieveNoteSelection($invitation_id, $typeDossier, $dossier_id) {

    $doctrineQuery = $this->createQuery('e')
                    ->where('est_globale = 1')
                    ->andWhere('est_preselection = 0')
                    ->andWhere('invitation_id = ?',$invitation_id )
                    ->andWhere('est_actif = 1')
                    ->andWhere($typeDossier . '_id = ?', $dossier_id);

    $arrEvaluation =  $doctrineQuery->execute();

    $objEvaluation = $arrEvaluation[0] ;

    if($objEvaluation->getValeurNoteId() != null){
      return Valeur_noteTable::getInstance()->findOneById($objEvaluation->getValeurNoteId())->getIntitule();
    }else{
      return null;
    }

    
  }

     /**
   * Retourne la query pour la fonction retrieveEvaluationFinaleDossier
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Actimage
   * @return Doctrine_Query
   */
  public function retrieveQueryEvaluationFinaleDossier($dossier_id,$typeDossier){

     $doctrineQuery = $this->createQuery('e')
                    ->where('est_finale = 1')
                    ->andWhere('est_preselection = 0')
                    ->andWhere('est_actif = 1')
                    ->andWhere($typeDossier . '_id = ?', $dossier_id);

      return $doctrineQuery;


  }

   /**
   * Retrouve la note finale du dossier
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Actimage
   * @return Object Evaluation
   */
  public function retrieveEvaluationFinaleDossier($dossier_id,$typeDossier){

    $doctrineQuery =  $this->retrieveQueryEvaluationFinaleDossier($dossier_id, $typeDossier);

    $arrEvaluation =  $doctrineQuery->execute();

    $objEvaluation = $arrEvaluation[0] ;

    return $objEvaluation;
    
  }

  /**
   * Retourne toutes les évaluations de préselection d'un dossier pour toutes les notes disponibles sauf la globale
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Julien GAUTIER
   * @return doctrineCollection
   */
  public function getEvaluationPreselectionByDossierId($dossier_id, $typeDossier) {

    if ($typeDossier == 'dossier_these') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 1')
                      ->andWhere('est_globale = 0')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_these_id = ?', $dossier_id)
                      ->orderBy("note_id ASC");
    } else if ($typeDossier == 'dossier_postdoc') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 1')
                      ->andWhere('est_globale = 0')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id)
                      ->orderBy("note_id ASC");
    } else if ($typeDossier == 'dossier_ere') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 1')
                      ->andWhere('est_globale = 0')
                      ->andWhere('invitation_id IS NULL ')
                      ->andWhere('dossier_ere_id = ?', $dossier_id)
                      ->orderBy("note_id ASC");
    }

    return $doctrineQuery->execute();
  }

  /**
   * Retourne toutes les évaluations de selection d'un dossier pour toutes les notes disponibles sauf la globale
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Julien GAUTIER
   * @return doctrineCollection
   */
  public function getEvaluationSelectionByDossierId($dossier_id, $typeDossier) {

    if ($typeDossier == 'dossier_these') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_these_id = ?', $dossier_id)
                      ->orderBy("note_id ASC")
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_postdoc') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id)
                      ->orderBy("note_id ASC")
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_ere') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_ere_id = ?', $dossier_id)
                      ->orderBy("note_id ASC")
                      ->orderBy("invitation_id ASC");
    }

    return $doctrineQuery->execute();
  }

  /**
   * Retourne les notes globales de selection d'un dossier
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Julien GAUTIER
   * @return doctrineCollection
   */
  public function getEvaluationGlobaleSelectionByDossierId($dossier_id, $typeDossier) {

    if ($typeDossier == 'dossier_these') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 1')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_these_id = ?', $dossier_id)
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_postdoc') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 1')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id)
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_ere') {
      $doctrineQuery = $this->createQuery('e')
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 1')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_ere_id = ?', $dossier_id)
                      ->orderBy("invitation_id ASC");
    }

    return $doctrineQuery->execute();
  }

  /**
   * Retourne les identifiants des invitations ayant posé des évaluations
   *
   * @param String $typeDossier le type de dossier (dossier_these, dossier_postdoc, dossier_ere)
   * @param Integer $dossier_id Id du dossier
   * @author Julien GAUTIER
   * @return doctrineCollection
   */
  public function getInvitationEvaluationSelectionByDossierId($dossier_id, $typeDossier) {

    if ($typeDossier == 'dossier_these') {
      $doctrineQuery = Doctrine_Query::create()
                      ->select('invitation_id')->distinct(true)
                      ->from($this->getTableName())
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_these_id = ?', $dossier_id)
                      ->groupBy('invitation_id')
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_postdoc') {
      $doctrineQuery = Doctrine_Query::create()
                      ->select('invitation_id')->distinct(true)
                      ->from($this->getTableName())
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_postdoc_id = ?', $dossier_id)
                      ->groupBy('invitation_id')
                      ->orderBy("invitation_id ASC");
    } else if ($typeDossier == 'dossier_ere') {
      $doctrineQuery =Doctrine_Query::create()
                      ->select('invitation_id')->distinct(true)
                      ->from($this->getTableName())
                      ->where('est_preselection = 0')
                      ->andWhere('est_globale = 0')
                      ->andWhere('est_finale = 0')
                      ->andWhere('dossier_ere_id = ?', $dossier_id)
                      ->groupBy('invitation_id')
                      ->orderBy("invitation_id ASC");
    }

    return $doctrineQuery->execute();
  }
}