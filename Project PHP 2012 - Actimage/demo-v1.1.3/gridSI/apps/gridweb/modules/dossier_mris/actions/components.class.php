<?php
/**
 * Components pour visualiser un dossier MRIS (les 3 types)
 * @author Julien GAUTIER
 */
class dossier_mrisComponents extends sfComponents
{

  /**
   *
   *  SECTION POUR L'ONGLET DESCRIPTION
   *
   */
  public function executeVoirDescriptionDossier_these(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');

    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierThese = Dossier_theseTable::getInstance()->findOneById($this->dossierId);
    $this->objStatutDossierThese = null;
    if ($this->objDossierThese->getStatutDossierTheseId() > 0) {
      $this->objStatutDossierThese = Statut_dossier_theseTable::getInstance()->findOneById($this->objDossierThese->getStatutDossierTheseId());
    }
    $this->objTypeConventionOrganismeThese = null;
     if ($this->objDossierThese->getTypeConventionOrganismeId() > 0) {
       $this->objTypeConventionOrganismeThese = Type_convention_organismeTable::getInstance()->findOneById($this->objDossierThese->getTypeConventionOrganismeId());
     }

    //Informations sur le proposant
    $this->proposantThese = $this->objDossierThese->getEtudiant();
    $this->proposantAdresseFrThese = 1;
    if (!$this->proposantThese->getVilleId()) {
      $this->proposantAdresseFrThese = 0;
    }

    //Partie infos complémentaires
    $this->hasPDFThese = false;
    $this->hasEditableThese = false;
    if (is_file( sfConfig::get('app_documents_mris_dossier_these_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierThese->getFichierPdf())) {
      $this->hasPDFThese = true;
    }
    if (is_file( sfConfig::get('app_documents_mris_dossier_these_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierThese->getFichierEditable())) {
      $this->hasEditableThese = true;
    }

    //Partie des encadrants
    $this->encadrantsThese = $this->objDossierThese->getEncadrant_these();
    $this->nbEncadrantsThese = $this->encadrantsThese->count();

    //Partie des laboratoires d'accueil
    $this->laboratoiresThese = $this->objDossierThese->getDossier_these_laboratoire();
    $this->nbLaboratoiresThese = $this->laboratoiresThese->count();
  }

  public function executeVoirDescriptionDossier_ere(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');

    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierEre = Dossier_ereTable::getInstance()->findOneById($this->dossierId);
    $this->objStatutDossierEre = null;
    if ($this->objDossierEre->getStatutDossierEreId() > 0) {
      $this->objStatutDossierEre = Statut_dossier_ereTable::getInstance()->findOneById($this->objDossierEre->getStatutDossierEreId());
    }
    
    //Informations sur le proposant
    $this->proposantEre = $this->objDossierEre->getEtudiant();
    $this->proposantAdresseFrEre = 1;
    if (!$this->proposantEre->getVilleId()) {
      $this->proposantAdresseFrEre = 0;
    }

    //Partie infos complémentaires
    $this->hasPDFEre = false;
    $this->hasEditableEre = false;
    if (is_file( sfConfig::get('app_documents_mris_dossier_ere_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierEre->getFichierPdf())) {
      $this->hasPDFEre = true;
    }
    if (is_file( sfConfig::get('app_documents_mris_dossier_ere_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierEre->getFichierEditable())) {
      $this->hasEditableEre = true;
    }

    //Partie des encadrants
    $this->encadrantsEre = $this->objDossierEre->getEncadrant_ere();
    $this->nbEncadrantsEre = $this->encadrantsEre->count();

    //Partie des laboratoires d'accueil
    $this->laboratoiresEre = $this->objDossierEre->getDossier_ere_laboratoire();
    $this->nbLaboratoiresEre = $this->laboratoiresEre->count();
  }

  public function executeVoirDescriptionDossier_postdoc(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');

    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierPostdoc = Dossier_postdocTable::getInstance()->findOneById($this->dossierId);
    $this->objStatutDossierPostdoc = null;
    if ($this->objDossierPostdoc->getStatutDossierPostdocId() > 0) {
      $this->objStatutDossierPostdoc = Statut_dossier_postdocTable::getInstance()->findOneById($this->objDossierPostdoc->getStatutDossierPostdocId());
    }
    
    //Informations sur le proposant
    $this->proposantPostdoc = $this->objDossierPostdoc->getEtudiant();
    $this->proposantAdresseFrPostdoc = 1;
    if (!$this->proposantPostdoc->getVilleId()) {
      $this->proposantAdresseFrPostdoc = 0;
    }

    //Partie infos complémentaires
    $this->hasPDFPostdoc = false;
    $this->hasEditablePostdoc = false;
    if (is_file( sfConfig::get('app_documents_mris_dossier_postdoc_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierPostdoc->getFichierPdf())) {
      $this->hasPDFPostdoc = true;
    }
    if (is_file( sfConfig::get('app_documents_mris_dossier_postdoc_repertoire') . DIRECTORY_SEPARATOR . $this->objDossierPostdoc->getFichierEditable())) {
      $this->hasEditablePostdoc = true;
    }

    //Partie des encadrants
    $this->encadrantsPostdoc = $this->objDossierPostdoc->getEncadrant_postdoc();
    $this->nbEncadrantsPostdoc = $this->encadrantsPostdoc->count();

    //Partie des laboratoires d'accueil
    $this->laboratoiresPostdoc = $this->objDossierPostdoc->getDossier_postdoc_laboratoire();
    $this->nbLaboratoiresPostdoc = $this->laboratoiresPostdoc->count();
  }

   /**
   *
   *  SECTION POUR L'ONGLET EVALUATION
   *
   */
  public function executeVoirEvaluationDossier_these(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');

    //Récupératoin de l'évaluation finale
    $evalFinale = EvaluationTable::getInstance()->retrieveEvaluationFinaleDossier($this->dossierId, 'dossier_these');
    if ($evalFinale && $evalFinale->getValeurNoteId()) {
      $valeurNote = Valeur_noteTable::getInstance()->findOneById($evalFinale->getValeurNoteId());
      $this->evaluationFinaleThese = $valeurNote->getIntitule();
    } else {
      $this->evaluationFinaleThese = "";
    }
    //Récupératoin des évaluations de présélection
    $this->evaluationPreselectionThese = EvaluationTable::getInstance()->getEvaluationPreselectionByDossierId($this->dossierId, 'dossier_these');
    $this->evaluationGlobalePreselectionThese = EvaluationTable::getInstance()->getEvaluationPreselectionByTypeDossierAndEstGlobal('Dossier_these', $this->dossierId)->getFirst();

    //Récupératoin des évaluations des sélections
    $evaluationSelectionThese = EvaluationTable::getInstance()->getEvaluationSelectionByDossierId($this->dossierId, 'dossier_these');
    $arrayEvalSelections = array();
    //Mise en tableau des notes sous la forme table[note][invite] afin de facilité la contruction de l'affichage
    foreach ($evaluationSelectionThese as $evaluationThese) {
      $arrayEvalSelections[$evaluationThese->getNoteId()][$evaluationThese->getInvitationId()] = $evaluationThese;
    }
    $this->evaluationSelectionThese = $arrayEvalSelections;
    $this->evaluationGlobaleSelectionThese = EvaluationTable::getInstance()->getEvaluationGlobaleSelectionByDossierId($this->dossierId, 'dossier_these');
    $this->notesListe = NoteTable::getInstance()->findAllOrderById();
    $this->invitationListe = EvaluationTable::getInstance()->getInvitationEvaluationSelectionByDossierId($this->dossierId, 'dossier_these');
  }

  public function executeVoirEvaluationDossier_ere(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');

    //Récupératoin de l'évaluation finale
    $evalFinale = EvaluationTable::getInstance()->retrieveEvaluationFinaleDossier($this->dossierId, 'dossier_ere');
    if ($evalFinale && $evalFinale->getValeurNoteId()) {
      $valeurNote = Valeur_noteTable::getInstance()->findOneById($evalFinale->getValeurNoteId());
      $this->evaluationFinaleEre = $valeurNote->getIntitule();
    } else {
      $this->evaluationFinaleEre = "";
    }
    //Récupératoin des évaluations de présélection
    $this->evaluationPreselectionEre = EvaluationTable::getInstance()->getEvaluationPreselectionByDossierId($this->dossierId, 'dossier_ere');
    $this->evaluationGlobalePreselectionEre = EvaluationTable::getInstance()->getEvaluationPreselectionByTypeDossierAndEstGlobal('Dossier_ere', $this->dossierId)->getFirst();

    //Récupératoin des évaluations des sélections
    $evaluationSelectionEre = EvaluationTable::getInstance()->getEvaluationSelectionByDossierId($this->dossierId, 'dossier_ere');
    $arrayEvalSelections = array();
    //Mise en tableau des notes sous la forme table[note][invite] afin de facilité la contruction de l'affichage
    foreach ($evaluationSelectionEre as $evaluationEre) {
      $arrayEvalSelections[$evaluationEre->getNoteId()][$evaluationEre->getInvitationId()] = $evaluationEre;
    }
    $this->evaluationSelectionEre = $arrayEvalSelections;
    $this->evaluationGlobaleSelectionEre = EvaluationTable::getInstance()->getEvaluationGlobaleSelectionByDossierId($this->dossierId, 'dossier_ere');
    $this->notesListe = NoteTable::getInstance()->findAllOrderById();
    $this->invitationListe = EvaluationTable::getInstance()->getInvitationEvaluationSelectionByDossierId($this->dossierId, 'dossier_ere');
  }

  public function executeVoirEvaluationDossier_postdoc(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');

    //Récupératoin de l'évaluation finale
    $evalFinale = EvaluationTable::getInstance()->retrieveEvaluationFinaleDossier($this->dossierId, 'dossier_postdoc');
    if ($evalFinale && $evalFinale->getValeurNoteId()) {
      $valeurNote = Valeur_noteTable::getInstance()->findOneById($evalFinale->getValeurNoteId());
      $this->evaluationFinalePostdoc = $valeurNote->getIntitule();
    } else {
      $this->evaluationFinalePostdoc = "";
    }
    //Récupératoin des évaluations de présélection
    $this->evaluationPreselectionPostdoc = EvaluationTable::getInstance()->getEvaluationPreselectionByDossierId($this->dossierId, 'dossier_postdoc');
    $this->evaluationGlobalePreselectionPostdoc = EvaluationTable::getInstance()->getEvaluationPreselectionByTypeDossierAndEstGlobal('Dossier_postdoc', $this->dossierId)->getFirst();

    //Récupératoin des évaluations des sélections
    $evaluationSelectionPostdoc = EvaluationTable::getInstance()->getEvaluationSelectionByDossierId($this->dossierId, 'dossier_postdoc');
    $arrayEvalSelections = array();
    //Mise en tableau des notes sous la forme table[note][invite] afin de facilité la contruction de l'affichage
    foreach ($evaluationSelectionPostdoc as $evaluationPostdoc) {
      $arrayEvalSelections[$evaluationPostdoc->getNoteId()][$evaluationPostdoc->getInvitationId()] = $evaluationPostdoc;
    }
    $this->evaluationSelectionPostdoc = $arrayEvalSelections;
    $this->evaluationGlobaleSelectionPostdoc = EvaluationTable::getInstance()->getEvaluationGlobaleSelectionByDossierId($this->dossierId, 'dossier_postdoc');
    $this->notesListe = NoteTable::getInstance()->findAllOrderById();
    $this->invitationListe = EvaluationTable::getInstance()->getInvitationEvaluationSelectionByDossierId($this->dossierId, 'dossier_postdoc');
  }

  /**
   *
   *  SECTION POUR L'ONGLET SUIVI ET ABOUTISSEMENT
   *
   */
  public function executeVoirSuiviDossier_these(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->objDossierThese = Dossier_theseTable::getInstance()->findOneById($this->dossierId);

    //Récupération des données d'aboutissement (dates + infor sur le prix de thèse)
    $this->aboutissementThese = Aboutissement_theseTable::getInstance()->findOneByDossierTheseId($this->dossierId);

    //Récupération des données de suivi
    $this->suiviDossierThese = Suivi_dossier_theseTable::getInstance()->getSuiviByDossierIdOrderedByType($this->dossierId,  'dossier_these');

    //Récupération des données de suivi post-commission
    $this->suiviPostCommThese = Avis_mrisTable::getInstance()->getAvisByDossierId($this->dossierId,  'dossier_these');

    //Récupération des évènements
    $objRequeteDoctrine = Evenement_mrisTable::getInstance()->getEvenementsByDossierId($this->dossierId,  'dossier_these');
    $this->evenementsThese = $objRequeteDoctrine->execute();
  }

  public function executeVoirSuiviDossier_ere(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->objDossierEre = Dossier_ereTable::getInstance()->findOneById($this->dossierId);

    //Récupération des données d'aboutissement
    $this->aboutissementEre = Aboutissement_ereTable::getInstance()->findOneByDossierEreId($this->dossierId);

    //Récupération des données de suivi
    $this->suiviDossierEre = Suivi_dossier_ereTable::getInstance()->getSuiviByDossierIdOrderedByType($this->dossierId,  'dossier_ere');

    //Récupération des données de suivi post-commission
    $this->suiviPostCommEre = Avis_mrisTable::getInstance()->getAvisByDossierId($this->dossierId,  'dossier_ere');

    //Récupération des évènements
    $objRequeteDoctrine = Evenement_mrisTable::getInstance()->getEvenementsByDossierId($this->dossierId,  'dossier_ere');
    $this->evenementsEre = $objRequeteDoctrine->execute();
  }

  public function executeVoirSuiviDossier_postdoc(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->objDossierPostdoc = Dossier_postdocTable::getInstance()->findOneById($this->dossierId);

    //Récupération des données d'aboutissement
    $this->aboutissementPostdoc = Aboutissement_postdocTable::getInstance()->findOneByDossierPostdocId($this->dossierId);

    //Récupération des données de suivi
    $this->suiviDossierPostdoc = Suivi_dossier_postdocTable::getInstance()->getSuiviByDossierIdOrderedByType($this->dossierId,  'dossier_postdoc');

    //Récupération des données de suivi post-commission
    $this->suiviPostCommPostdoc = Avis_mrisTable::getInstance()->getAvisByDossierId($this->dossierId,  'dossier_postdoc');

    //Récupération des évènements
    $objRequeteDoctrine = Evenement_mrisTable::getInstance()->getEvenementsByDossierId($this->dossierId,  'dossier_postdoc');
    $this->evenementsPostdoc = $objRequeteDoctrine->execute();
  }
}

