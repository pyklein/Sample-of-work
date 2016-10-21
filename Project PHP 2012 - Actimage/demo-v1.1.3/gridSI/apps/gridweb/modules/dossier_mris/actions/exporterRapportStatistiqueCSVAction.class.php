<?php

/**
 * Export CSV des rapports statistiques
 *
 * @author Jihad SAHEBDIN
 */
class exporterRapportStatistiqueCSVAction extends gridAction {

  /**
   * @var sfLogger
   */
  var $logger;


  public function preExecute() {
    if (sfContext::hasInstance()) {
      $this->logger = $this->getLogger();
    }
  }

  public function execute($request) {
    if (sfContext::hasInstance()) {
      $this->logger->debug(__CLASS__ . "->" . __FUNCTION__ . "() Start");
    }

    
    
    $strTypeDossier = $request->getParameter('typeDossier');
    //le filtre
    if($strTypeDossier == "Dossier_these")
    {
      $this->objFormFiltre = new Dossier_theseStatistiquesFormFilter();
    }
    else if($strTypeDossier == "Dossier_postdoc")
    {
      $this->objFormFiltre = new Dossier_postdocStatistiquesFormFilter();
    }
    else if($strTypeDossier == "Dossier_ere")
    {
      $this->objFormFiltre = new Dossier_ereStatistiquesFormFilter();
    }

    $strFilterName = $this->objFormFiltre->getName();

    if ($this->getUser()->hasAttributeAction('filtre_dossier_theses', "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_these"))
    {
      $this->logger->debug("Avec le filtre");
      $this->getUser()->setAttributeAction('filtre_dossier_theses', $this->getUser()->getAttributeAction('filtre_dossier_theses', null, "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_these"));
    }
    else if ($this->getUser()->hasAttributeAction('filtre_dossier_postdocs', "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_postdoc"))
    {
      $this->logger->debug("Avec le filtre");
      $this->getUser()->setAttributeAction('filtre_dossier_postdocs', $this->getUser()->getAttributeAction('filtre_dossier_postdocs', null, "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_postdoc"));
    }
    else if ($this->getUser()->hasAttributeAction('filtre_dossier_eres', "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_ere"))
    {
      $this->logger->debug("Avec le filtre");
      $this->getUser()->setAttributeAction('filtre_dossier_eres', $this->getUser()->getAttributeAction('filtre_dossier_eres', null, "dossier_mris/voirRapportStatistiquesEtTableauDeBord_Dossier_ere"));
    }
    else
    {
      $this->logger->debug("Sans filtre");
    }

    $objRequeteDoctrine = $this->processFiltre();

    $this->resultatsPropositionDomaineScientifique= null;
    $this->resultatsDossiersDomaineScientifique = null;
    $this->resultatsRegionProposition = null;
    $this->resultatsRegionDossier = null;
    $this->resultatsPropositionOrigine = null;
    $this->resultatsDossierOrigine = null;
    $this->resultatsCofinance = null;
    $this->resultatsNonCofinance = null;
    $this->resultatsAvecEvaluation = null;
    $this->resultatsSansEvaluation = null;
    $this->resultatsPropositionOrganisme = null;
    $this->resultatsDossierOrganisme = null;
    


//On determine les groupements présents
    $this->groupPropositionDS = true;
    $this->groupDossierDS = true;
    $this->groupRegion = true;
   

    if ($request->hasParameter($strFilterName))
    {
      $arrParams = $request->getParameter($strFilterName);
      if ($arrParams['domaine_scientifique_id'] != '')
      {
        $this->groupPropositionDS = false;
        $this->groupDossierDS = false;
      }
      if ($arrParams['region_laboratoire'] != '')
      {
        $this->groupRegion = false;
      }
    }

    
    $DossierTable = $strTypeDossier."Table";
    $StatutDossierTable = "Statut_".strtolower($strTypeDossier)."Table";
    
    //Récupération des résultats pour chaque tableau
    if ($this->groupPropositionDS && $request->getParameter('typeStat') == 'Proposition_DS')
    {
      $this->resultatsPropositionDomaineScientifique = $DossierTable::getInstance()->getCountsByDomaineScientifique($objRequeteDoctrine);
    }
    
    if ($this->groupDossierDS && $request->getParameter('typeStat') == 'Dossier_DS')
    {
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_'.  strtolower($strTypeDossier) .'_id = ?',  $StatutDossierTable::VALIDE);

      $this->resultatsDossiersDomaineScientifique = $DossierTable::getInstance()->getCountsByDomaineScientifique($result);
    }

    if ($this->groupRegion && $request->getParameter('typeStat') == 'region')
    {
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_'.  strtolower($strTypeDossier) .'_id = ?',  $StatutDossierTable::VALIDE);

      $this->resultatsRegionProposition = $DossierTable::getInstance()->getCountsByRegion($objRequeteDoctrine);
      $this->resultatsRegionDossier = $DossierTable::getInstance()->getCountsByRegion($result);
    }

    if ($request->getParameter('typeStat') == 'proposition_origine')
    {
      $this->resultatsPropositionOrigine = $DossierTable::getInstance()->getCountsByOrigine($objRequeteDoctrine);
    }

    if ($request->getParameter('typeStat') == 'dossier_origine')
    {
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_'.  strtolower($strTypeDossier) .'_id = ?',  $StatutDossierTable::VALIDE);
      $this->resultatsDossierOrigine = $DossierTable::getInstance()->getCountsByOrigine($result);
    }

    if ($request->getParameter('typeStat') == 'cofinancement')
    {
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhereIn('type_convention_organisme_id',array(Type_convention_organismeTable::THESE_COFINANCEE,Type_convention_organismeTable::THESE_COFINANCEE_PAR_REGION,Type_convention_organismeTable::THESE_COFINANCEE_PAR_INDUSTRIEL));
      $this->resultatsCofinance = $result->count();
      
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('type_convention_organisme_id=?',Type_convention_organismeTable::THESE_NON_COFINANCEE);
      $this->resultatsNonCofinance = $result->count();

    }

    if ($request->getParameter('typeStat') == 'soutenance')
    {
      $date = date("Y-m-d");
      $date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($date)) . " -3 month"));

      $result = clone $objRequeteDoctrine;
      $rootAlias = $result->getRootAlias();
      $result = $result->leftJoin($rootAlias.'.AboutissementThese ab')
              ->andWhere('ab.date_soutenance >= ?',$date);

      $nonRecu = clone $result;
      $nonRecu = $nonRecu->andWhere('reception_fiche_evaluation is NULL');

      $recu = clone $result;
      $recu = $recu->andWhere('reception_fiche_evaluation is NOT NULL');

      $this->resultatsAvecEvaluation = $recu->count();
      $this->resultatsSansEvaluation = $nonRecu->count();
    }

    if ($request->getParameter('typeStat') == 'organisme')
    {
      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_'.  strtolower($strTypeDossier) .'_id = ?',  $StatutDossierTable::VALIDE);

      $this->resultatsPropositionOrganisme = $DossierTable::getInstance()->getCountsByOrganisme($objRequeteDoctrine);
      $this->resultatsDossierOrganisme = $DossierTable::getInstance()->getCountsByOrganisme($result);
    }
    

    // creation du fichier + téléchargement
    if ($request->getParameter('typeStat') == 'Proposition_DS')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsPropositionDomaineScientifique);
    }
    if ($request->getParameter('typeStat') == 'Dossier_DS')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsDossiersDomaineScientifique);
    }
    if ($request->getParameter('typeStat') == 'region')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsRegionProposition, $this->resultatsRegionDossier);
    }
    if ($request->getParameter('typeStat') == 'proposition_origine')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis"). ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsPropositionOrigine);
    }
    if ($request->getParameter('typeStat') == 'dossier_origine')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsDossierOrigine);
    }
    if ($request->getParameter('typeStat') == 'cofinancement')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsCofinance, $this->resultatsNonCofinance);
    }
    if ($request->getParameter('typeStat') == 'soutenance')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsAvecEvaluation, $this->resultatsSansEvaluation);
    }
    if ($request->getParameter('typeStat') == 'organisme')
    {
      $strNomFichier = "export_rapport_statistique_".$strTypeDossier."_".$request->getParameter('typeStat') . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsPropositionOrganisme, $this->resultatsDossierOrganisme);
    }


    if (sfContext::hasInstance()) {
      $this->logger->debug(__CLASS__ . "->" . __FUNCTION__ . "() End");
    }


  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param $arrResultats[] $arrResultatsDossiers
   * @author Jihad SAHEBDIN
   */
  private function creerFichier($strNomFichier, $arrResultats1=array(), $arrResultats2=array()) {
    $this->logger->debug("{" . __CLASS__ . "} " . __FUNCTION__ . " - strNomFichier: " . $strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);
    
    $intTotalProposition = 0;
    $intTotalDossier = 0;
    

    // contenu en fonction du type


    if ($this->getRequest()->getParameter('typeStat') == 'Proposition_DS')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_proposition_dom_scientifiques"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_domaine_scientifique"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_propositions"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterLigne();
      }
    }
    if ($this->getRequest()->getParameter('typeStat') == 'Dossier_DS')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_dossier_dom_scientifiques"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_domaine_scientifique"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossiers"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterLigne();
      }
    }

    if ($this->getRequest()->getParameter('typeStat') == 'region')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_region"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_region"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_propositions"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossiers"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterValeur($arrResultats2[$objResultat]);
        $objUtilCsv->ajouterLigne();
      }
    }

    if ($this->getRequest()->getParameter('typeStat') == 'proposition_origine')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_proposition_origine"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_etudiant_type_cursus"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_propositions"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterLigne();
      }
    }

    if ($this->getRequest()->getParameter('typeStat') == 'dossier_origine')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_dossier_origine"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_etudiant_type_cursus"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossiers"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterLigne();
      }
    }

    if ($this->getRequest()->getParameter('typeStat') == 'cofinancement')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_cofinancement"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_financements"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossiers"));
      $objUtilCsv->ajouterLigne();

      $objUtilCsv->ajouterValeur(libelle("msg_libelle_cofinance"));
      $objUtilCsv->ajouterValeur($arrResultats1);
      $objUtilCsv->ajouterLigne();

      $objUtilCsv->ajouterValeur(libelle("msg_libelle_non_cofinance"));
      $objUtilCsv->ajouterValeur($arrResultats2);
      $objUtilCsv->ajouterLigne();
      
    }

    if ($this->getRequest()->getParameter('typeStat') == 'soutenance')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_statistiques_these_soutenance"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("-"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossiers"));
      $objUtilCsv->ajouterLigne();

      $objUtilCsv->ajouterValeur(libelle("msg_libelle_fiche_evaluation"));
      $objUtilCsv->ajouterValeur($arrResultats1);
      $objUtilCsv->ajouterLigne();

      $objUtilCsv->ajouterValeur(libelle("msg_libelle_aucune_fiche"));
      $objUtilCsv->ajouterValeur($arrResultats2);
      $objUtilCsv->ajouterLigne();

    }

    if ($this->getRequest()->getParameter('typeStat') == 'organisme')
    {
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nb_dossier_par_organisme"));
      $objUtilCsv->ajouterLigne();
      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_organisme"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nb_propositions"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nb_dossiers"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats1 as $objResultat => $count)
      {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $intTotalProposition += $count;
        
        $objUtilCsv->ajouterValeur($arrResultats2[$objResultat]);
        $intTotalDossier += $arrResultats2[$objResultat];
        
        $objUtilCsv->ajouterLigne();
      }
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_total"));
      $objUtilCsv->ajouterValeur($intTotalProposition);
      $objUtilCsv->ajouterValeur($intTotalDossier);
      $objUtilCsv->ajouterLigne();

    }

    


    $this->logger->debug("{" . __CLASS__ . "} " . __FUNCTION__ . " - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();
  }

}
?>
