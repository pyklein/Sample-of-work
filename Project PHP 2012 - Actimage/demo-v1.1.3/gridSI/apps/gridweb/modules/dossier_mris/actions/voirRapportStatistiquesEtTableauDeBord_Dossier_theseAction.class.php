<?php

/**
 * Statistiques et Tableau de bord des dossiers de thèse
 *
 * @author Jihad SAHEBDIN
 */
class voirRapportStatistiquesEtTableauDeBord_Dossier_theseAction extends gridAction
{
  public function execute($request) 
  {
    $this->objFormFiltre = new Dossier_theseStatistiquesFormFilter();
    $objRequeteDoctrine = $this->processFiltre() ;

    $this->arrDossiersTrouves = $objRequeteDoctrine->execute();
    $this->intNbDossiersTrouves = $objRequeteDoctrine->count();
    $this->intNbDossiersProposition = Dossier_theseTable::getInstance()->findAll()->count();

    $this->resultatsOrganismesProposition = array();
    $this->resultatsOrganismesDossiers = array();
    $this->intTotalProposition = 0;
    $this->intTotalValide = 0;

    //On determine les statistiques à afficher
    $this->groupPropositionDS = true;
    $this->groupDossierDS = true;
    $this->groupPropositionOrigine = true;
    $this->groupDossierOrigine = true;
    $this->groupCofinancement = true;
    $this->groupSoutenance = true;
    $this->groupRegion = true;
    $this->groupOrganisme = true;

    
    if ($this->objFormFiltre->getValue('domaine_scientifique_id') != '')
    {
      $this->groupPropositionDS = false;
      $this->groupDossierDS = false;
    }

    if ($this->objFormFiltre->getValue('region_laboratoire') != '')
    {
      $this->groupRegion = false;
    }

    


    //Purge des anciennes images
    $utilFichier = new UtilFichier();
    $utilArbo = new ServiceArborescence();
    $utilFichier->purgerFichiers($utilArbo->getRepertoireTemporaire(), "(stat_dossier_these).*(\.png)", 60);

    if($this->intNbDossiersTrouves > 0)
    {
//      Répartition par domaines scientifique
      if ($this->groupPropositionDS)
      {
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur'), sfConfig::get('app_image_genere_hauteur'));
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_theseTable::getInstance()->getCountsByDomaineScientifique($objRequeteDoctrine) as $objDomaineScientifique => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objDomaineScientifique;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartPropositionDS = $srvChart->creerCamembertLegendeACote($libelle, $donnees, $libelle2, "stat_dossier_these_proposition_dom_scientifique");
        }
      }

      if ($this->groupDossierDS)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhere('statut_dossier_these_id = ?',  Statut_dossier_theseTable::VALIDE);
        
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur'), sfConfig::get('app_image_genere_hauteur'));
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_theseTable::getInstance()->getCountsByDomaineScientifique($result) as $objDomaineScientifique => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objDomaineScientifique;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartDossierDS = $srvChart->creerCamembertLegendeACote($libelle, $donnees, $libelle2, "stat_dossier_these_dossier_dom_scientifique");
        }
      }

      //répartition des propositions et dossiers par région
      if ($this->groupRegion)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhereIn('statut_dossier_these_id',array(Statut_dossier_theseTable::PROPOSITION,Statut_dossier_theseTable::REFUSE, Statut_dossier_theseTable::MIS_EN_ATTENTE ));
        
        $valide = clone $objRequeteDoctrine;
        $valide = $valide->andWhere('statut_dossier_these_id = ?',  Statut_dossier_theseTable::VALIDE);

         //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur'), sfConfig::get('app_image_genere_hauteur'));
        $donnees = array();
        $libelle = array() ;
        $legende = array();
        $minVal = 999999999;
        $maxVal = 0;
        $maxVal2 = 0;
        foreach (Dossier_theseTable::getInstance()->getCountsByRegion($result) as $region => $compte)
        {
          $donnees[] = $compte;
          $libelle[] = $region;
          if ($compte < $minVal) $minVal = $compte;
          if ($compte > $maxVal) $maxVal = $compte;
        }

        $legende = array(libelle("msg_libelle_propositions"),libelle("msg_libelle_dossiers"));

        foreach (Dossier_theseTable::getInstance()->getCountsByRegion($valide) as $region => $compte2)
        {
          $donnees2[] = $compte2;
          if ($compte2 > $maxVal2) $maxVal2 = $compte2;
        }

        $maxVal += $maxVal2;

       
        

        // Création du graphique
        if (count($donnees) > 0) {
          $srvChart->setNbCouleurs(2);
          $srvChart->creerEntetePourBarGraph($libelle, $donnees, $legende, $donnees2, true);
          $srvChart->getObjetGraphique()->setGraphArea(50,30,sfConfig::get('app_image_genere_largeur')-100,sfConfig::get('app_image_genere_hauteur')-100);
          $srvChart->getObjetGraphique()->setFixedScale(0, $maxVal, $maxVal);
          $srvChart->getObjetGraphique()->drawScale($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(),SCALE_ADDALLSTART0,150,150,150,TRUE,25,2);

          $srvChart->getObjetGraphique()->drawStackedBarGraph($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(),50);
          
          $libelleLegende = array("Position"=>"SerieLegend", "Values"=>array("Serie1"), "Description"=>$legende);
          $legendeBox = $srvChart->getObjetGraphique()->getLegendBoxSize($libelleLegende);
          $srvChart->getObjetGraphique()->drawLegend(sfConfig::get('app_image_genere_largeur') - 10 - $legendeBox[0],15,$srvChart->getObjetConfiguration()->GetDataDescription(),255,255,255);
          $srvChart->genererGraphique("stat_dossier_these_region");

          $this->chartRegion = $srvChart->getFichierGraphique();
        }
      }

//      Groupements répartition par origine
      if ($this->groupPropositionOrigine)
      {
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_theseTable::getInstance()->getCountsByOrigine($objRequeteDoctrine) as $objCursus => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objCursus;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartPropositionOrigine = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_these_proposition_origine");
        }
      }

      if ($this->groupDossierOrigine)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhere('statut_dossier_these_id = ?',  Statut_dossier_theseTable::VALIDE);

        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_theseTable::getInstance()->getCountsByOrigine($result) as $objCursus => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objCursus;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartDossierOrigine = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_these_dossier_origine");
        }
      }

//      Répartition des cofinancements
      if ($this->groupCofinancement)
      {
        $cofinance = clone $objRequeteDoctrine;
        $cofinance = $cofinance->andWhereIn('type_convention_organisme_id',array(Type_convention_organismeTable::THESE_COFINANCEE,Type_convention_organismeTable::THESE_COFINANCEE_PAR_REGION,Type_convention_organismeTable::THESE_COFINANCEE_PAR_INDUSTRIEL, Type_convention_organismeTable::DECISION_FINANCIERE));

        $nonCofinance = clone $objRequeteDoctrine;
        $nonCofinance = $nonCofinance->andWhere('type_convention_organisme_id=?',Type_convention_organismeTable::THESE_NON_COFINANCEE);

        $intNbCofinance = $cofinance->count();
        $intNbNonCofinance = $nonCofinance->count();
        $compte = $intNbCofinance + $intNbNonCofinance;
        
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;

        if ($compte > 0)
        {
          $donnees = array($intNbCofinance,$intNbNonCofinance);
          $libelle = array(libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($intNbCofinance)),libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($intNbNonCofinance)));
          $libelle2 = array(libelle("msg_libelle_cofinance"),  libelle("msg_libelle_non_cofinance"));
        }
      

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartCofinancement = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_these_cofinancement");
        }
      }

//      Theses soutenues dans les 3 mois
      if ($this->groupSoutenance)
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
        
        $intNbNonRecu = $nonRecu->count();
        $intNbRecu = $recu->count();
        
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        
        if ($result->count() > 0)
        {
          $donnees = array($intNbRecu,$intNbNonRecu);
          $libelle = array(libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($intNbRecu)),libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($intNbNonRecu)));
          $libelle2 = array(libelle("msg_libelle_fiche_evaluation"),libelle("msg_libelle_aucune_fiche"));

        }
       
        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartSoutenance = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_these_soutenance");
        }
      }
    }

//    Nombre de dossiers par organisme
    if ($this->groupOrganisme)
    {
      $intIndex = 0;
      foreach (Dossier_theseTable::getInstance()->getCountsByOrganisme($objRequeteDoctrine) as $org => $compte)
      {
        array_push($this->resultatsOrganismesProposition, array($org => $compte));
        $intIndex++;
        $this->intTotalProposition += $compte;
      }

      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_dossier_these_id = ?',  Statut_dossier_theseTable::VALIDE);
      $intIndex = 0;
      foreach (Dossier_theseTable::getInstance()->getCountsByOrganisme($result) as $org => $compte)
      {
        array_push($this->resultatsOrganismesDossiers, array($org => $compte));
        $intIndex++;
        $this->intTotalValide += $compte;
      }
    }    
  }   
}
