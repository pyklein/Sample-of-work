<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of voirRapportStatistiqueAction
 *
 * @author Julien GAUTIER
 */
class voirRapportStatistiqueAction extends gridAction {

  public function execute($request) {
    $this->getContext()->getConfiguration()->loadHelpers('Libelle');
    $this->objFormFiltre = new Dossier_bpiStatistiquesFormFilter();
    $strFilterName = $this->objFormFiltre->getName();
    $objRequeteDoctrine = $this->processFiltre();

    //On determine les statistiques à afficher
    $this->groupClassement = true;
    $this->groupOrganismesMindef = true;
    $this->groupBrevet = true;
    $this->groupAnnee = true;
    $this->groupEntite = true;
    
    if ($this->objFormFiltre->getValue('organisme_mindef_id') != '') {
      $this->groupOrganismesMindef = false;
    }
    if ($this->objFormFiltre->getValue('entite_id') != '') {
      $this->groupEntite = false;
    }
    $arrCreatedAt = $this->objFormFiltre->getValue('created_at');
    if ($arrCreatedAt != array('from' => null, 'to' => null) && $arrCreatedAt != null) {
      if (substr($arrCreatedAt['to'], 7) == substr($arrCreatedAt['from'], 7)) {
        $this->groupAnnee = false;
      }
    }

    //Purge des anciennes images
    $utilFichier = new UtilFichier();
    $utilArbo = new ServiceArborescence();
    $utilFichier->purgerFichiers($utilArbo->getRepertoireTemporaire(), "(bpi_supervision).*(\.png)", 60);

    //Récupération des résultats pour chaque tableau
    $this->nbDossierTotal = Dossier_bpiTable::getInstance()->getCountDossiers($objRequeteDoctrine);
    $this->getUser()->setAttribute('supBpiNbDossierTotal', $this->nbDossierTotal);

    if ($this->nbDossierTotal > 0) {
      if ($this->groupClassement) {
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
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
          $this->getUser()->setAttribute('supBpiChartClassement', $this->chartClassement);
        }
      }
      if ($this->groupOrganismesMindef) {
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
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
          $this->getUser()->setAttribute('supBpiChartOrganismesMindef', $this->chartOrganismesMindef);
        }
        
      }
      if ($this->groupBrevet) {
        //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $nbBrevetable = Dossier_bpiTable::getInstance()->getCountDossiersBrevetables($objRequeteDoctrine);
        $donnees = array($this->nbDossierTotal - $nbBrevetable, $nbBrevetable) ;
        $libelle = array(libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($this->nbDossierTotal - $nbBrevetable)), libelle_graphiques("msg_statistiques_bpi_libelle_dossier", array($nbBrevetable))) ;
        $libelle2 = array(libelle("msg_statistiques_bpi_libelle_non_brevetable"), libelle("msg_statistiques_bpi_libelle_brevetable")) ;
        
        //Création du graphique
        if (count($donnees) > 0) {
          $this->chartBrevet = $srvChart->creerCamembert($libelle, $donnees, $libelle2, "bpi_supervision_brevet");
          $this->getUser()->setAttribute('supBpiChartBrevet', $this->chartBrevet);
        }
      }
      if ($this->groupAnnee) {
         //Préparation des données
        $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
        $donnees = array() ;
        $libelle = array() ;
        $minVal = 0;
        $maxVal = 0;
        foreach (Dossier_bpiTable::getInstance()->getCountsByAnnees($objRequeteDoctrine) as $annee => $compte) {
            $donnees[] = $compte;
            $libelle[] = $annee;
            if ($compte < $minVal) $minVal = $compte;
            if ($compte > $maxVal) $maxVal = $compte;
        }
//        $minVal--;
        $maxVal++;
        //Création du graphique
        if (count($donnees) > 0) {
//          $srvChart->setNbCouleurs(count($donnees));
          $srvChart->creerEntete($libelle, $donnees, true);
          $srvChart->getObjetGraphique()->setGraphArea(30,20,sfConfig::get('app_image_genere_largeur')/2-30,sfConfig::get('app_image_genere_hauteur')/2-45);
          $srvChart->getObjetGraphique()->setFixedScale($minVal, $maxVal, $maxVal);
          $srvChart->getObjetGraphique()->drawScale($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(),SCALE_ADDALLSTART0,150,150,150,TRUE,45,2);

          $srvChart->getObjetGraphique()->drawBarGraph($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(), TRUE);
          $srvChart->genererGraphique("bpi_supervision_annee");

          $this->chartAnnee = $srvChart->getFichierGraphique() ;
          $this->getUser()->setAttribute('supBpiChartAnnee', $srvChart->getFichierGraphique());
        }
      }
      if ($this->groupEntite) {
        $this->tableEntite = Dossier_bpiTable::getInstance()->getCountsByEntite($objRequeteDoctrine);
      }
    }
  }

}

?>
