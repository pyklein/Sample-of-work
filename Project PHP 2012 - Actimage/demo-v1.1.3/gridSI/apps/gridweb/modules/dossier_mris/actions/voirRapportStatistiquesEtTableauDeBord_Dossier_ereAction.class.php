<?php

/**
 * Statistiques et Tableau de bord des dossiers de stage ERE
 *
 * @author Jihad SAHEBDIN
 */
class voirRapportStatistiquesEtTableauDeBord_Dossier_ereAction extends gridAction
{
  public function execute($request) 
  {
    $this->objFormFiltre = new Dossier_ereStatistiquesFormFilter();
    $objRequeteDoctrine = $this->processFiltre() ;

    $this->arrDossiersTrouves = $objRequeteDoctrine->execute();
    $this->intNbDossiersTrouves = $objRequeteDoctrine->count();
    $this->intNbDossiersProposition = Dossier_ereTable::getInstance()->findAll()->count();

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
    $utilFichier->purgerFichiers($utilArbo->getRepertoireTemporaire(), "(stat_dossier_ere).*(\.png)", 60);

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
        foreach (Dossier_ereTable::getInstance()->getCountsByDomaineScientifique($objRequeteDoctrine) as $objDomaineScientifique => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objDomaineScientifique;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartPropositionDS = $srvChart->creerCamembertLegendeACote($libelle, $donnees, $libelle2, "stat_dossier_ere_proposition_dom_scientifique");
        }
      }

      if ($this->groupDossierDS)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhere('statut_dossier_ere_id = ?',  Statut_dossier_ereTable::VALIDE);
        
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur'), sfConfig::get('app_image_genere_hauteur'));
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_ereTable::getInstance()->getCountsByDomaineScientifique($result) as $objDomaineScientifique => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objDomaineScientifique;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartDossierDS = $srvChart->creerCamembertLegendeACote($libelle, $donnees, $libelle2, "stat_dossier_ere_dossier_dom_scientifique");
        }
      }

      //répartition des propositions et dossiers par région
      if ($this->groupRegion)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhereIn('statut_dossier_ere_id',array(Statut_dossier_ereTable::PROPOSITION,Statut_dossier_ereTable::REFUSE, Statut_dossier_ereTable::MIS_EN_ATTENTE ));

        $valide = clone $objRequeteDoctrine;
        $valide = $valide->andWhere('statut_dossier_ere_id = ?',  Statut_dossier_ereTable::VALIDE);

         //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur'), sfConfig::get('app_image_genere_hauteur'));
        $donnees = array() ;
        $libelle = array() ;
        $legende = array();
        $minVal = 999999999;
        $maxVal = 0;
        $maxVal2 = 0;
        foreach (Dossier_ereTable::getInstance()->getCountsByRegion($result) as $region => $compte)
        {
          $donnees[] = $compte;
          $libelle[] = $region;
          if ($compte < $minVal) $minVal = $compte;
          if ($compte > $maxVal) $maxVal = $compte;
        }

        $legende = array(libelle("msg_libelle_propositions"),libelle("msg_libelle_dossiers"));

        foreach (Dossier_ereTable::getInstance()->getCountsByRegion($valide) as $region => $compte2)
        {
          $donnees2[] = $compte2;
        }


        //Création du graphique
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
          $srvChart->genererGraphique("stat_dossier_ere_region");

          $this->chartRegion = $srvChart->getFichierGraphique() ;
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
        foreach (Dossier_ereTable::getInstance()->getCountsByOrigine($objRequeteDoctrine) as $objCursus => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objCursus;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartPropositionOrigine = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_ere_proposition_origine");
        }
      }

      if ($this->groupDossierOrigine)
      {
        $result = clone $objRequeteDoctrine;
        $result = $result->andWhere('statut_dossier_ere_id = ?',  Statut_dossier_ereTable::VALIDE);

        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $libelle2 = array() ;
        foreach (Dossier_ereTable::getInstance()->getCountsByOrigine($result) as $objCursus => $compte) {
          if ($compte > 0) {
            $donnees[] = $compte;
            $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
            $libelle2[] = $objCursus;
          }
        }

        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartDossierOrigine = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "stat_dossier_ere_dossier_origine");
        }
      }
    }

//    Nombre de dossiers par organisme
    if ($this->groupOrganisme)
    {
      $intIndex = 0;
      foreach (Dossier_ereTable::getInstance()->getCountsByOrganisme($objRequeteDoctrine) as $org => $compte)
      {
        array_push($this->resultatsOrganismesProposition, array($org => $compte));
        $intIndex++;
        $this->intTotalProposition += $compte;
      }

      $result = clone $objRequeteDoctrine;
      $result = $result->andWhere('statut_dossier_ere_id = ?',  Statut_dossier_ereTable::VALIDE);
      $intIndex = 0;
      foreach (Dossier_ereTable::getInstance()->getCountsByOrganisme($result) as $org => $compte)
      {
        array_push($this->resultatsOrganismesDossiers, array($org => $compte));
        $intIndex++;
        $this->intTotalValide += $compte;
      }
    }
  }
}
