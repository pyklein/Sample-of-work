<?php

/**
 * Description of exporterRapportStatistiquePDFAction
 *
 * @author William
 */
class exporterRapportStatistiquePDFAction extends gridAction {

  public function execute($request) {
    $this->pdf = 1;
    $this->getContext()->getConfiguration()->loadHelpers('Libelle');
    $this->objFormFiltre = new Dossier_bpiStatistiquesFormFilter();
    $strFilterName = $this->objFormFiltre->getName();
    if ($this->getUser()->hasAttributeAction('filtre_dossier_bpis', "dossier_bpi/voirRapportStatistique")) {
      $this->getUser()->setAttributeAction('filtre_dossier_bpis', $this->getUser()->getAttributeAction('filtre_dossier_bpis', null, "dossier_bpi/voirRapportStatistique"));
    }
    $objRequeteDoctrine = $this->processFiltre();

    $objUtilArbo = new ServiceArborescence();
    $strCheminTmp = $objUtilArbo->getRepertoireTemporaire();

    //On determine les statistiques à afficher
    $this->boolFiltre = false;
    $this->groupClassement = true;
    $this->groupOrganismesMindef = true;
    $this->groupBrevet = true;
    $this->groupAnnee = true;
    $this->groupEntite = true;

      if ($this->objFormFiltre->getValue('organisme_mindef_id') != '') {
        $this->boolFiltre = true;
        $this->groupOrganismesMindef = false;
        $this->headerOrganismesMindef = libelle('msg_libelle_organisme_armee') . ' : ' . Organisme_mindefTable::getInstance()->findOneById($this->objFormFiltre->getValue('organisme_mindef_id'));
      }
      if ($this->objFormFiltre->getValue('entite_id') != '') {
        $this->boolFiltre = true;
        $this->groupEntite = false;
        $this->headerEntite = libelle('msg_statistiques_bpi_libelle_entite') . ' : ' . EntiteTable::getInstance()->findOneById($this->objFormFiltre->getValue('entite_id'));
      }
      $arrCreatedAt = $this->objFormFiltre->getValue('created_at');
      if ($arrCreatedAt != array('from' => null, 'to' => null) && $arrCreatedAt != null) {
        $this->boolFiltre = true;
         $this->headerAnnee = libelle('msg_statistiques_bpi_libelle_date') . ' : ' . $arrCreatedAt['to']. ' ' .  libelle('msg_remarque_et_le') . ' : ' . $arrCreatedAt['from'];
         if (substr($arrCreatedAt['to'], 7) == substr($arrCreatedAt['from'], 7)) {
          $this->groupAnnee = false;
        }
      }

    //Récupération des résultats pour chaque tableau
    $this->nbDossierTotal = $this->getUser()->getAttribute("supBpiNbDossierTotal");

    if ($this->nbDossierTotal > 0) {
       if ($this->groupClassement) {
        $chartClassement = $this->getUser()->getAttribute("supBpiChartClassement");
        if (is_file($strCheminTmp . $chartClassement)) {
          $this->chartClassement = $chartClassement;
        } else {
          //Préparation des données
          $srvChart = new ServiceChart();
          $donnees = array() ;
          $libelle = array() ;
          $libelle2 = array() ;
          $totalClassement = 0;
          $totalDossiersClassement = Dossier_bpiTable::getInstance()->getCountDossiersClassement($objRequeteDoctrine);
          foreach (Dossier_bpiTable::getInstance()->getCountsByClassement($objRequeteDoctrine) as $classement => $compte) {
            if ($compte > 0) {
              $donnees[] = $compte;
              $totalClassement += $compte;
              $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_classement", array($compte));
              $libelle2[] = $classement;
            }
          }

          //Création du graphique
          if (count($donnees) > 0) {
            $complement = libelle_graphiques("msg_statistiques_bpi_libelle_graph_classement_complement", array($totalDossiersClassement,$totalClassement));
            $this->chartClassement = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "bpi_supervision_classement", "", $complement);
          }
        }
      }
      if ($this->groupOrganismesMindef) {
        $chartOrganismesMindef = $this->getUser()->getAttribute("supBpiChartOrganismesMindef");
        if (is_file($strCheminTmp . $chartOrganismesMindef)) {
          $this->chartOrganismesMindef = $chartOrganismesMindef;
        } else {
          //Préparation des données
          $srvChart = new ServiceChart();
          $donnees = array() ;
          $libelle = array() ;
          $libelle2 = array() ;
          foreach (Dossier_bpiTable::getInstance()->getCountsByOrganisme($objRequeteDoctrine) as $organisme => $compte) {
            if ($compte > 0) {
              $donnees[] = $compte;
              $libelle[] = libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($compte));
              $libelle2[] = $organisme;
            }
          }


          //Création du graphique
          if (count($donnees) > 0) {
            $this->chartOrganismesMindef = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "bpi_supervision_organismes");
          }
        }
      }
      if ($this->groupBrevet) {
        $chartBrevet = $this->getUser()->getAttribute("supBpiChartBrevet");
        if (is_file($strCheminTmp . $chartBrevet)) {
          $this->chartBrevet = $chartBrevet;
        } else {
          //Préparation des données
          $srvChart = new ServiceChart();
          $nbBrevetable = Dossier_bpiTable::getInstance()->getCountDossiersBrevetables($objRequeteDoctrine);
          $donnees = array($this->nbDossierTotal - $nbBrevetable, $nbBrevetable) ;
          $libelle = array(libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($this->nbDossierTotal - $nbBrevetable)), libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($nbBrevetable))) ;
          $libelle2 = array(libelle("msg_statistiques_bpi_libelle_non_brevetable"), libelle("msg_statistiques_bpi_libelle_brevetable")) ;

          //Création du graphique
          if (count($donnees) > 0) {
            $this->chartBrevet = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "bpi_supervision_brevet");
          }
        }
      }
      if ($this->groupAnnee) {
        $chartAnnee = $this->getUser()->getAttribute("supBpiChartAnnee");
        if (is_file($strCheminTmp . $chartAnnee)) {
          $this->chartAnnee = $chartAnnee;
        } else {
          //Préparation des données
          $srvChart = new ServiceChart();
          $donnees = array() ;
          $libelle = array() ;
          $minVal = 999999999;
          $maxVal = 0;
          foreach (Dossier_bpiTable::getInstance()->getCountsByAnnees($objRequeteDoctrine) as $annee => $compte) {
              $donnees[] = $compte;
              $libelle[] = $annee;
              if ($compte < $minVal) $minVal = $compte;
              if ($compte > $maxVal) $maxVal = $compte;
          }
          $minVal--;
          $maxVal++;
          //Création du graphique
          if (count($donnees) > 0) {
            $srvChart->setNbCouleurs(count($donnees));
            $srvChart->creerEntete($libelle, $donnees, true);
            $srvChart->getObjetGraphique()->AntialiasQuality = 0;
            $srvChart->getObjetGraphique()->setGraphArea(30,20,340,220);
            $srvChart->getObjetGraphique()->setFixedScale($minVal, $maxVal, 8);
            $srvChart->getObjetGraphique()->drawScale($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(),SCALE_ADDALLSTART0,150,150,150,TRUE,0,2);

            $srvChart->getObjetGraphique()->drawBarGraph($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(), TRUE);
            $srvChart->genererGraphique("bpi_supervision_annee");

            $this->chartAnnee = $srvChart->getFichierGraphique() ;
          }
        }
      }
      if ($this->groupEntite) {
        $this->tableEntite = Dossier_bpiTable::getInstance()->getCountsByEntite($objRequeteDoctrine);
      }
    }

    $this->setTemplate('voirRapportStatistique');
  }

}

?>
